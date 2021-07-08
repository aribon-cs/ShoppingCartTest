<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotFoundException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class NotFoundException extends ApiBaseException
{
    /**
     * CustomBadException constructor.
     *
     * @param $message
     * @param int $code
     */
    public function __construct($message, Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message, $previous, $headers, $code);
    }
}
