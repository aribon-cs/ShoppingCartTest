<?php

namespace App\Controller;

use App\Traits\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ApiAbstractController.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class AbstractApiController extends AbstractController
{
    use ApiResponseTrait;
}
