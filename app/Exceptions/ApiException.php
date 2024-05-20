<?php

namespace App\Exceptions;

use Exception;

/**
 * A custom exception for the API errors
 */
class ApiException extends Exception
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
        $this->error = $error;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->error,
        ], $this->statusCode);
    }
}
