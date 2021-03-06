<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CustomBadException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class CustomBadException extends ApiBaseException
{
    /**
     * CustomBadException constructor.
     *
     * @param $message
     * @param int $code
     */
    public function __construct($message, Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $previous, $headers, $code);
    }
}
