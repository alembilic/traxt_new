<?php

namespace App\Services\Dinero;

use App\Exceptions\AuthServiceException;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;

/**
 * DataForSEO service
 */
class DineroService
{
    /**
     * @var string
     */
    protected string $baseUrl = 'https://api.dinero.dk/v1';

    /**
     * Returns an invoice content.
     *
     * @param string $id Invoice identifier
     *
     * @return string
     *
     * @throws AuthServiceException
     * @throws ServiceException
     */
    public function getInvoice(string $id): string
    {
        $result = Cache::get($id);
        if (!$result) {
            $curl = curl_init('https://api.dinero.dk/v1/' . config('services.dinero.id') . '/invoices/' . $id);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '. $this->getAuthToken(),
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
     */
    private function getAuthToken(): string
    {
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

        return $data['access_token'];
    }
}
