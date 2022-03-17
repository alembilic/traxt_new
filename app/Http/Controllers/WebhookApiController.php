<?php

namespace App\Http\Controllers;

use App\Services\Webhooks\WebhooksServicesFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebhookApiController extends BaseApiController
{
    /**
     * @param string $type
     * @param Request $request
     * @param WebhooksServicesFactory $servicesFactory
     *
     * @return Response
     *
     * @throws BindingResolutionException
     */
    public function handle(string $type, Request $request, WebhooksServicesFactory $servicesFactory): Response
    {
        $servicesFactory->build($type)->handleWebhook($request);

        return response()->noContent();
    }
}
