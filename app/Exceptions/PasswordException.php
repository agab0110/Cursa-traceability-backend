<?php

namespace App\Exceptions;

use Exception;

class PasswordException extends Exception
{
    protected $error;
    protected $statusCode;

    public function __construct($error, $statusCode)
    {
        parent::__construct($error);
        $this->message = $error;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->error,
        ], $this->statusCode);
    }
}
