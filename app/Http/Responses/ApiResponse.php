<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * A custom response for the APIs
 */
class ApiResponse implements Responsable {
    protected $message;
    protected $data;
    protected $statusCode;

    /**
     * @param string $message the message shown in the json
     * @param mixed $data the data returned
     * @param int $statusCode the status code of the response
     */
    public function __construct($message, $data, $statusCode) {
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function toResponse($request) {
        return response()->json([
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
