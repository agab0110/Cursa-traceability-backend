<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * A custom response for the password resets
 */
class PasswordResponse implements Responsable {
    protected $message;
    protected $statusCode;

    /**
     * @param string $message the message shown in the json
     * @param int $statusCode the status code of the response
     */
    public function __construct($message, $statusCode) {
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
        ], $this->statusCode);
    }
}
