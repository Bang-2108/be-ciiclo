<?php

namespace App\Traits;

trait ApiResponse {
    protected function success($data, $message = "Success", $code = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function error($message = "Error", $code = 500, $errors = []) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }
}