<?php

namespace App\Controller;

use InvalidArgumentException;

/**
 * A wrapper for holding data to be used for a application/problem+json response
 * used in throw Exceptions, then kernel got them and return to client.
 *
 * Class ApiExceptionController
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ApiExceptionController
{
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';
    private static array $titles = [
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    ];
    private int $statusCode;
    private string $type;
    private $title;
    private array $extraData = [];

    /**
     * ApiProblem constructor.
     */
    public function __construct(int $statusCode = 200, string $type = self::TYPE_VALIDATION_ERROR)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;
        if (!isset(self::$titles[$type])) {
            throw new InvalidArgumentException('No title for type '.$type);
        }
        $this->title = self::$titles[$type];
    }

    final public function toArray(): array
    {
        $responseBody = [
            'status' => $this->statusCode,
            'data' => $this->title,
//            'type' => $this->type,
        ];

        if ($this->statusCode >= 400) {
            $responseBody['errors'] = $this->title;
            unset($responseBody['data']);
        }

        return array_merge($this->extraData, $responseBody);
    }

    /**
     * @param $name
     * @param $value
     */
    final public function set(string $name, string $value): void
    {
        $this->extraData[$name] = $value;
    }

    final public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    final public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    final public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
