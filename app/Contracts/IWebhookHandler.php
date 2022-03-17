<?php

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Contract for Webhook Handler.
 */
interface IWebhookHandler
{
    public function handleWebhook(Request $request): void;
}
