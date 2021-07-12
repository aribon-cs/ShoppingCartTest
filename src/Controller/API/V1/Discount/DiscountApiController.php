<?php

namespace App\Controller\API\V1\Discount;

use App\Controller\AbstractApiController;
use App\Entity\Discount;
use App\Service\DiscountService;
use App\Service\Validation\ValidationService;
use App\Validator\Constraint\DiscountUpdateConstraint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discount", name="discount_")
 */
class DiscountApiController extends AbstractApiController
{

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function index(DiscountService $discountService): JsonResponse
    {
        return $this->respondWithSuccess($discountService->applyFilterWithPaginate());
    }

    /**
     * @Route("/{id}", name="detail", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function detail(Discount $discount, DiscountService $discountService): JsonResponse
    {
        return $this->respondWithSuccess($discountService->getTransformer()->transformModel($discount));
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function update(Discount $discount, DiscountService $discountService, ValidationService $validationService, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), true);
        $validationService->validateByConstraint($input, DiscountUpdateConstraint::getConstraint());

        $discountService->update($discount, $input);

        return $this->respondWithSuccess($discountService->getTransformer()->transformModel($discount));
    }
}
