<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use SoapClient;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VatApiController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $countryCode = $request->get('countryCode') ?? '';
            $vatNo = $request->get('vatNo') ?? '';

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
                $result['isEU'] = in_array($countryCode, config('app.eu_country_codes'));
            } else {
                throw new BadRequestHttpException('Vat number and Country code are required fields');
            }
        } catch (Exception $e) {
            $result['status'] = 'error';
            $result['response'] = $e->getMessage();
        }

        return JsonResponse::fromJsonString(json_encode($result));
    }
}
