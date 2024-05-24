<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * A custom response for authentication methods
 */
class AuthResponse implements Responsable {
    protected $message;
    protected $data;
    protected $token;
    protected $status;

    /**
     * @param string $message the message shown in the json
     * @param mixed $data the data returned
     * @param mixed $token the user's token
     * @param int $status the status code of the response
     */
    public function __construct($message, $data, $token, $status) {
        $this->message = $message;
        $this->data = $data;
        $this->token = $token;
        $this->status = $status;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
            'token' => $this->token,
            'token_type' => 'Bearer',
        ], $this->status);
    }
}
