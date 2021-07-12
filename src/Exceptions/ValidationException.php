<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ValidationException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ValidationException extends ApiBaseException
{
    /**
     * ValidationException constructor.
     *
     * @param $message
     * @param int $code
     */
    public function __construct($message, Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $previous, $headers, $code);
    }
}
