<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class AuthResponse implements Responsable {
    protected $message;
    protected $data;
    protected $token;
    protected $statusCode;

    public function __construct($message, $data, $token, $statusCode) {
        $this->$message = $message;
        $this->$data = $data;
        $this->$token = $token;
        $this->$statusCode = $statusCode;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
            'token' => $this->token,
            'token_type' => 'Bearer',
        ], $this->statusCode);
    }
}
