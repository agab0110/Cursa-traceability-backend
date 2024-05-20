<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $message;
    protected $statusCode;

    /**
     * @param string $message the message shown in the json
     * @param int $statusCode the status code of the response
     */
    public function __construct($message, $statusCode)
    {
        parent::__construct($message);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'error' => true,
            'message' => $this->message,
        ], $this->statusCode);
    }
}
