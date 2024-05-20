<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class AuthResponse implements Responsable {
    protected $message;
    protected $statusCode;

    public function __construct($message, $statusCode) {
        $this->$message = $message;
        $this->$statusCode = $statusCode;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
        ], $this->statusCode);
    }
}
