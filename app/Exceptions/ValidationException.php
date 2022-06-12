<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Contracts\Validation\Validator;

class ValidationException extends \Exception
{

    protected Validator $validator;

    protected $code = 422;

    public function __construct(Validator $validator, $code = 0, Throwable $previous = null)
    {
        $this -> validator = $validator;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            "error" => "form validation error",
            "message" => $this->validator->errors()
        ], $this->code);
    }
}
