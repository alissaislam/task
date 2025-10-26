<?php 
namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data, $message = '', $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ], $code);
    }

    public function errorResponse($message = '', $code = 500)
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'status' => $code,
        ], $code);
    }
}
