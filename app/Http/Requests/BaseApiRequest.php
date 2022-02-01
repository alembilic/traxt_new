<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Base request for all api requests.
 */
abstract class BaseApiRequest extends FormRequest
{
    /**
     * Returns request validation rules.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Shows whether current request could be executed.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }
}
