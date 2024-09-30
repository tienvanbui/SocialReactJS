<?php

namespace App\Exceptions;

use App\Enums\ErrorType;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // API response
        if ($request->is('api/*')) {
            // Custom Exception
            if ($exception instanceof Responsable) {
                return $exception->toResponse($request);
            }

            // Validation Exception
            if ($exception instanceof ValidationException) {
                return $this->getBasicResponse(ErrorType::CODE_INVALID_PARAMETERS, $exception->errors(), ErrorType::STATUS_INVALID_PARAMETERS);
            }

            // ModelNotFoundException
            if ($exception instanceof ModelNotFoundException) {
                return $this->getBasicResponse(ErrorType::CODE_NOT_FOUND, __('errors.MSG_NOT_FOUND'), ErrorType::STATUS_NOT_FOUND);
            }

            // HTTP Exception
            if ($this->isHttpException($exception)) {
                if ($exception->getStatusCode() == ErrorType::STATUS_INVALID_REQUEST) {
                    return $this->getBasicResponse(ErrorType::CODE_INVALID_REQUEST, __('errors.MSG_INVALID_REQUEST'), ErrorType::STATUS_INVALID_REQUEST);
                }

                if ($exception->getStatusCode() == ErrorType::STATUS_NOT_FOUND) {
                    return $this->getBasicResponse(ErrorType::CODE_NOT_FOUND, __('errors.MSG_NOT_FOUND'), ErrorType::STATUS_NOT_FOUND);
                }

                if ($exception->getStatusCode() == ErrorType::STATUS_METHOD_NOT_ALLOWED) {
                    return $this->getBasicResponse(ErrorType::CODE_METHOD_NOT_ALLOWED, __('errors.MSG_METHOD_NOT_ALLOWED'), ErrorType::STATUS_METHOD_NOT_ALLOWED);
                }

                if ($exception->getStatusCode() == ErrorType::STATUS_OVER_CAPACITY) {
                    return $this->getBasicResponse(ErrorType::CODE_OVER_CAPACITY, __('errors.MSG_OVER_CAPACITY'), ErrorType::STATUS_OVER_CAPACITY);
                }
            }

            return $this->getBasicResponse(ErrorType::CODE_INTERNAL_ERROR, __('errors.MSG_INTERNAL_ERROR'), ErrorType::STATUS_INTERNAL_ERROR);
        }

        // Web response
        return parent::render($request, $exception);
    }

    private function getBasicResponse(string $code, $message, int $status)
    {
        $response = [
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        return response()->json($response, $status);
    }
}
