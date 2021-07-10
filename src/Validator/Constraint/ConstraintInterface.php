<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Interface ConstraintInterface.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
interface ConstraintInterface
{
    public static function getConstraint(): Assert\Collection;
}
