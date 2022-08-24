<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends Exception {

    protected $validator;

    protected $code = 422;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function report()
    {
        Log::error('Validation Error: ', [$this->validator->errors()]);
    }

    public function render() {
        // return a json with desired format
        return response()->json([
            "code" => 422,
            "message" => $this->validator->errors()
        ], $this->code);
    }
}