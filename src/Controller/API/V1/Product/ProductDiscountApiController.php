<?php

namespace App\Controller\API\V1\Product;

use App\Controller\AbstractApiController;
use App\Entity\Product;
use App\Service\DiscountService;
use App\Service\Validation\ValidationService;
use App\Transformer\DiscountTransformer;
use App\Validator\Constraint\DiscountConstraint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product_discount_")
 */
class ProductDiscountApiController extends AbstractApiController
{

    /**
     * @Route("/{id}/discount", name="list", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function list(Product $product, DiscountTransformer $discountTransformer): JsonResponse
    {
        return $this->respondWithSuccess($discountTransformer->transformCollection($product->getDiscounts(), 'list'));
    }

    /**
     * @Route("/{id}/discount", name="add_discount", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function addDiscountToProduct(
        Product $product,
        Request $request,
        ValidationService $validationService,
        DiscountService $discountService
    ): JsonResponse {
        $input = json_decode($request->getContent(), true) ?? [];
        $validationService->validateByConstraint($input, DiscountConstraint::getConstraint());

        $discount = $discountService->insert($input, $product);

        return $this->respondWithSuccess($discountService->getTransformer()->transformModel($discount, 'simple'));
    }
}
