<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send a success response in JSON format.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function sendSuccessResponse(mixed $data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status_code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Send an error response in JSON format.
     *
     * @param string $message
     * @param mixed $errors
     * @param int $code
     * @return JsonResponse
     */
    public static function sendErrorResponse(string $message, mixed $errors = null, int $code = 500): JsonResponse
    {
        return response()->json([
            'status_code' => $code,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    public static function sendUnauthorizedResponse($message = null)
    {
        $message = $message ? $message : __('Unauthorized');
        return self::sendErrorResponse($message, null, 401);
    }

    public static function sendForbiddenResponse($message = null)
    {
        $message = $message ? $message : __('Forbidden');
        return self::sendErrorResponse($message, null, 403);
    }

    public static function sendNoDataResponse($message = null)
    {
        $message = $message ? $message : __('Data not found.');
        return self::sendErrorResponse($message, null, 404);
    }

    public static function sendServerErrorResponse($error = null, $message = null)
    {
        $message = $message ? $message : __('Something went wrong. Please try again later.');
        return self::sendErrorResponse($message, $error, 500);
    }

    public static function sendCreatedSuccessResponse($data = null, $message = null)
    {
        $message = $message ? $message : __('Created successfully!');
        return self::sendSuccessResponse($data, $message, 200);
    }
    public static function sendUpdatedSuccessResponse($data = true, $message = null)
    {
        $message = $message ? $message : __('Updated successfully!');
        return self::sendSuccessResponse($data, $message, 200);
    }
    public static function sendDeletedSuccessResponse($data = true, $message = null)
    {
        $message = $message ? $message : __('Deleted successfully!');
        return self::sendSuccessResponse($data, $message, 200);
    }
    public static function sendRestoreSuccessResponse($data = true, $message = null)
    {
        $message = $message ? $message : __('Restored successfully!');
        return self::sendSuccessResponse($data, $message, 200);
    }
}
