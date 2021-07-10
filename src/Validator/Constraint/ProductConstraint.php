<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductConstraint.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ProductConstraint implements ConstraintInterface
{
    final public static function getConstraint(): Assert\Collection
    {
        return new Assert\Collection(
            [
                'name' => new Assert\Required(
                    [
                        new Assert\Type(['type' => 'string', 'message' => 'type must be string']),
                        new Assert\NotBlank(),
                    ],
                ),
                'price' => [
                    new Assert\Required(
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
