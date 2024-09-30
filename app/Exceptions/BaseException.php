<?php

namespace App\Exceptions;

use App\Enums\ErrorType;
use Exception;

class BaseException extends Exception
{
    protected $code;

    protected $message;

    protected $statusCode;

    public function __construct($code = '', $message = '', $statusCode = ErrorType::STATUS_INTERNAL_ERROR)
    {
        $this->code = $code;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function setStatusCode(string $code)
    {
        $this->code = $code;
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function setErrorMessage(string $message)
    {
        $this->message = $message;
    }

    public function getErrorMessage()
    {
        return $this->message;
    }

    public function setErrorStatusCode(string $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getErrorStatusCode()
    {
        return $this->statusCode;
    }

    public function getBasicResponse()
    {
        return [
            'error' => [
                'code' => $this->getStatusCode(),
                'message' =>  $this->getMessage()
            ]
        ];
    }

    public function toResponse($request)
    {
        return response()->json(
            $this->getBasicResponse(),
            $this->getStatusCode(),
        );
    }
}
