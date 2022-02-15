<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use SoapClient;

class VatApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $countryCode = $request->get('countrycode') ?? '';
            $vatNo = $request->get('vatno') ?? '';

            if ($countryCode && $vatNo) {
                $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
                $vatInfo = $client->checkVat(array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNo
                ));

                $result['status'] = "success";
                $result['countryCode'] = $vatInfo->countryCode;
                $result['requestDate'] = $vatInfo->requestDate;
                $result['valid'] = $vatInfo->valid;
                $result['name'] = $vatInfo->name;
                $result['address'] = $vatInfo->address;
                $result['isEU'] = in_array($countryCode, [
                    'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'EI', 'ES', 'FI', 'FR', 'HU', 'IE',
                    'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
                ]);
            } else {
                $result['status'] = 'error';
                $result['response'] = 'Vat number and Country code are required fields';
            }
        } catch (Exception $e) {
            $result['status'] = 'error';
            $result['response'] = $e->getMessage();
        }

        return JsonResponse::fromJsonString(json_encode($result));
    }
}
