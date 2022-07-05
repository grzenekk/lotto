<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function responseWithData($data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
    }

    protected function responseSuccess($additionalParams = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(array_merge(['status' => 'success'], $additionalParams), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
    }

    protected function responseFailed($errorMsg, $errorCode = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'failed', 'error' => $errorMsg], $errorCode);
    }

    protected function response404($errorMsg = 'Not found'): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => 'failed', 'error' => $errorMsg], 404);
    }
}
