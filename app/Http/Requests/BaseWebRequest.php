<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Base request for all api requests.
 */
abstract class BaseWebRequest extends FormRequest
{
    /**
     * Returns request validation rules.
     *
     * @return array
     */
    abstract public function rules(): array;
}
