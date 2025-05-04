<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiTrait
{
    /**
     * @return JsonResponse
     */
    public function returnData($data, $msg = '')
    {
        return response()->json([
            'data' => $data,
            'message' => $msg,
            'status' => true,
        ], Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function successMessage($msg = '', $data = [], $status = Response::HTTP_OK)
    {
        return response()->json([
            'data' => [],
            'message' => $msg,
            'status' => true,
        ], Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function errorMessage($message, $customErrCode = null)
    {
        return response()->json([
            'data' => [],
            'message' => $message,
            'status' => false,
        ], $customErrCode ? $customErrCode : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return JsonResponse
     */
    public function NotFound()
    {
        return response()->json([
            'data' => [],
            'message' => __('general.data_not_found'),
            'status' => false,
        ], 404);
    }

    public function DataNotFound()
    {
        return response()->json([
            'data' => [],
            'message' => __('general.data_not_found'),
            'status' => false,
        ], 404);
    }
}
