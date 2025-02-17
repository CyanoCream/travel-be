<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;


class ApiResponse
{
    /**
     * Return a standardized API response
     *
     * @param bool $success
     * @param string $message
     * @param mixed $data
     * @param int|null $statusCode
     * @param array|null $pagination
     * @return JsonResponse
     */
    public static function make($success, $message, $data = [], $meta = null, $errCode = 400)
    {
        $errorCode = $success ? 200 : $errCode;
        $response = [
            'status' => $success,
            'message' => $message,
            'data' => $success ? $data : null,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }

        if (!$success) {
            unset($response['message']);
            $response['error'] = [
                "error_code" => $errorCode,
                "error_message" => $message
            ];
        }

        return response()->json($response, $errorCode);
    }

}
