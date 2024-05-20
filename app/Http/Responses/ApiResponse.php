<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable {
    protected $message;
    protected $data;
    protected $statusCode;

    public function __construct($message, $data, $statusCode) {
        $this->$message = $message;
        $this->$data = $data;
        $this->$statusCode = $statusCode;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
