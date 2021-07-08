<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TryLaterException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class TryLaterException extends ApiBaseException
{
    /**
     * TryLaterException constructor.
     *
     * @param $message
     * @param int $code
     */
    public function __construct($message = 'try again!', Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $previous, $headers, $code);
    }
}
