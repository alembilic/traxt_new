<?php

namespace App\Services\Dinero;

use App\Contracts\IAccountingSystem;
use App\Core\EntityManagerFresher;
use App\Entities\SubscriptionCharge;
use App\Entities\User;
use App\Exceptions\AuthServiceException;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * DataForSEO service
 */
class DineroService implements IAccountingSystem
{
    use EntityManagerFresher;

    /**
     * @var string
     */
    protected string $baseUrl = 'https://api.dinero.dk/v1/';

    /**
     * {@inheritDoc}
     */
    public function getInvoice(string $id): string
    {
        $result = Cache::get($id);
        if (!$result) {
            $curl = curl_init($this->baseUrl . config('services.dinero.id') . '/invoices/' . $id);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->getAuthToken(),
                'Host: api.dinero.dk',
                'Content-Type: application/json',
                'Accept: application/octet-stream'
            ]);
            $result = curl_exec($curl);
            $responseData = curl_getinfo($curl);
            curl_close($curl);

            if ($responseData['http_code'] === 200) {
                Cache::put($id, $result, 3600);
            }
        }
        if (!$result) {
            throw new ServiceException('Can\'t create invoice');
        }

        return $result;
    }

    /**
     * Authorization.
     *
     * @return string
     *
     * @throws AuthServiceException
     * @throws InvalidArgumentException
     */
    private function getAuthToken(): string
    {
        $token = Cache::get('dinero_auth_token');
        if ($token) {
            return $token;
        }

        $authKey = base64_encode(config('services.dinero.client_id') . ':' . config('services.dinero.secret'));
        $curl = curl_init('https://authz.dinero.dk/dineroapi/oauth/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'password',
            'scope' => 'read write',
            'username' => config('services.dinero.key'),
            'password' => config('services.dinero.key'),
        ]));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $authKey,
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        if (!$response) {
            throw new AuthServiceException();
        }

        $data = json_decode($response, 1);
        if (!($data['access_token'] ?? false)) {
            throw new AuthServiceException();
        }

        Cache::set('dinero_auth_token', $data['access_token'], 3600);

        return $data['access_token'];
    }

    /**
     * {@inheritDoc}
     */
    public function createUser(User $user): string
    {
        if ($user->getDineroAddGuid()) {
            return $user->getDineroAddGuid();
        }

        $contact = json_encode([
            'ExternalReference' => 'Traxr: ' . $user->getId(),
            'Name' => ($user->getCompany() ?: $user->getFirstname() . ' ' . $user->getLastname()),
            'Street' => $user->getAddress(),
            'ZipCode' => '',
            'City' => $user->getCity(),
            'CountryKey' => $user->getCountry(),
            'Phone' => null,
            'Email' => $user->getEmail(),
            'AttPerson' => $user->getFirstname() . ' ' . $user->getLastname(),
            'PaymentConditionType' => 'Netto',
            'PaymentConditionNumberOfDays' => 8,
            'UseCvr' => false,
            'IsPerson' => false,
        ]);

        $url = $this->baseUrl . config('services.dinero.id') . '/contacts';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->getAuthToken(),
            'Host: api.dinero.dk',
            'Content-Type: application/json',
            'Accept: application/octet-stream',
            'Content-Length: ' . strlen($contact)
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $contact);
        $response = curl_exec($curl);

        if ($errno = curl_errno($curl)) {
            throw new ServiceException(curl_strerror($errno));
        }
        if (!$response) {
            throw new ServiceException('Invalid response from Dinero API.' . $response);
        }

        $data = json_decode($response, 1);

        if (!$data['contactGuid']) {
            throw new ServiceException('Invalid response from Dinero API.' . $response);
        }

        $user->setDineroAddGuid($data['contactGuid']);
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $data['contactGuid'];
    }

    /**
     * {@inheritDoc}
     */
    public function createInvoice(User $user, SubscriptionCharge $charge): string
    {
        $url = $this->baseUrl . config('services.dinero.id') . '/invoices';
        $subscription = $charge->getSubscription();
        $AccountNumber = 1250;

        if ($user->getVatValid() === 'DK' || !$user->getVatValid()) {
            $AccountNumber = 1000;
        }
        if ($user->getVatValid() === 'EU') {
            $AccountNumber = 1200;
        }

        $requestData = json_encode([
            'PaymentConditionNumberOfDays' => 0,
            'PaymentConditionType' => 'Netto',
            'ContactGuid' => $user->getDineroAddGuid(),
            'ShowLinesInclVat' => false,
            'Currency' => 'USD',
            'Language' => 'en-GB',
            'ExternalReference' => 'Traxr: ' . $charge->getId() . '',
            'Description' => 'Invoice',
            'Date' => date('Y-m-d'),
            'ProductLines' => [[
                'BaseAmountValue' => $charge->getAmount(),
                'Description' => $subscription->getProduct()->getProductName() . ' - Next due date: ' .
                    $subscription->getNextDueDate()->format('Y-m-d'),
                'Quantity' => '1',
                'AccountNumber' => $AccountNumber,
                'Unit' => 'parts',
                'Discount' => '0',
                'LineType' => 'Product'
            ]],
            'Address' => null
        ]);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->getAuthToken(),
            'Host: api.dinero.dk',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($requestData)
        ));

        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);
        $response = curl_exec($curl);

        if ($errno = curl_errno($curl)) {
            throw new ServiceException(curl_strerror($errno));
        }
        if (!$response) {
            throw new ServiceException('Invalid response from Dinero API.' . $response);
        }

        $data = json_decode($response, 1);

        if (!$data['guid']) {
            throw new ServiceException('Invalid response from Dinero API.' . $response);
        }

        return $data['guid'];
    }
}
