<?php

namespace App\Exceptions;

use App\Controller\ApiExceptionController;
use App\Traits\ApiResponseTrait;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiBaseException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ApiBaseException extends HttpException
{
    use ApiResponseTrait;

    private ApiExceptionController $apiException;

    /**
     * ApiBaseException constructor.
     *
     * @param $statusCode
     * @param $message
     * @param int $code
     */
    public function __construct($statusCode, $message, Exception $previous = null, array $headers = [], $code = 0)
    {
        $apiProblem = new ApiExceptionController();
        $this->apiException = $apiProblem;
        $apiProblem->setStatusCode($statusCode);
        $apiProblem->setTitle($message);
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @return ApiExceptionController
     */
    public function getApiException()
    {
        return $this->apiException;
    }
}
