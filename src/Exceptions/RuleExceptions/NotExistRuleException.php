<?php

namespace App\Exceptions\RuleExceptions;

use App\Exceptions\ApiBaseException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CustomBadException.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class NotExistRuleException extends ApiBaseException
{
    /**
     * CustomBadException constructor.
     *
     * @param $message
     * @param $extraKey
     * @param $extraValue
     * @param int $code
     */
    public function __construct($message, $extraKey, $extraValue, Exception $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(Response::HTTP_NOT_ACCEPTABLE, $message, $previous, $headers, $code);
        $this->setExtra($extraKey, $extraValue);
    }
}
