<?php

namespace App\Services\Webhooks;

use App\Contracts\IWebhookHandler;
use App\Enums\WebhookTypes;
use App\Services\PaymentServices\QuickPayPaymentServiceService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Factory for Webhooks services.
 */
class WebhooksServicesFactory
{
    /**
     * Dependency injection container.
     *
     * @var Container
     */
    protected Container $container;

    /**
     * Mapping types with services which serves this types.
     *
     * @var array
     */
    protected array $servicesMapping = [
        WebhookTypes::QUICK_PAY => QuickPayPaymentServiceService::class,
    ];

    /**
     * Factory for statistics services.
     *
     * @param Container $container Dependency injection container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Returns implementation of webhook service by given type.
     *
     * @param string $type Type to which needs to return confirmation service
     *
     * @return IWebhookHandler
     *
     * @throws NotFoundHttpException
     * @throws BindingResolutionException
     */
    public function build(string $type): IWebhookHandler
    {
        if (!isset($this->servicesMapping[$type])) {
            throw new NotFoundHttpException('Webhook Service not found');
        }

        return $this->container->make($this->servicesMapping[$type]);
    }
}
