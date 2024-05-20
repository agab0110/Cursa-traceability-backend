<?php

namespace App\Exceptions;

use Exception;

class PasswordException extends Exception
{
    protected $error;
    protected $statusCode;

    /**
     * @param string $message the message shown in the json
     * @param int $statusCode the status code of the response
     */
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
