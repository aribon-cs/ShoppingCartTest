<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductUpdateConstraint.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ProductUpdateConstraint implements ConstraintInterface
{
    final public static function getConstraint(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'name' => new Assert\Optional(
                    [
                        new Assert\Type(['type' => 'string', 'message' => 'type must be string']),
                        new Assert\NotBlank(),
                    ],
                ),
                'price' => [
                    new Assert\Optional(
                        [
                            new Assert\Type(['type' => 'integer', 'message' => 'price must be integer']),
                            new Assert\Positive(),
                        ]
                    ),
                ],
            ]
        );
    }
}
