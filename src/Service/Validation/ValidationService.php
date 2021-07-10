<?php

namespace App\Service\Validation;

use App\Exceptions\ValidationException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidationService.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ValidationService
{
    private ValidatorInterface $validator;

    /**
     * ValidationService constructor.
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * validate request content based on given Model object that contain Assert annotation.
     *
     * @return array|object
     */
    public function validateByModel(string $requestContent, string $model, ?array $group = null): object
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $output = $serializer->deserialize($requestContent, $model, 'json');

        $errors = $this->validator->validate($output, null, $group);

        if (0 !== count($errors)) {
            $errorMessage = $errors[0]->getMessage(); // pass message to user if you want just add to exception message
            throw new ValidationException('Validation Failed '.$errorMessage);
        }

        return $output;
    }

    /**
     * validate array based on given Constraint object that contain Assert Array.
     */
    public function validateByConstraint(array $array, Collection $constrains, ?array $group = null): void
    {
        $errors = $this->validator->validate($array, $constrains, $group);
        if (0 !== count($errors)) {
            $errorMessage = $errors[0]->getMessage(); // pass message to user if you want just add to exception message
            throw new ValidationException('Validation Failed, '.$errorMessage);
        }
    }
}
