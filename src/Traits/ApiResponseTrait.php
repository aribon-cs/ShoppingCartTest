<?php

namespace App\Traits;

use App\Exceptions\CustomBadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ApiResponseTrait.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
trait ApiResponseTrait
{
    private int $statusCode = Response::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return ApiResponseTrait
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondUnprocessableEntity($message = 'Unprocessable entity!')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondFailedDependency($message = 'Failed Dependency!')
    {
        return $this->setStatusCode(Response::HTTP_FAILED_DEPENDENCY)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotAcceptable($message = 'Not acceptable!')
    {
        return $this->setStatusCode(Response::HTTP_NOT_ACCEPTABLE)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondForbidden($message = 'Forbidden, access denied!')
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondBadRequest($message = 'An error occurred!')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondUnauthorized($message = 'Request is unauthorized!')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondCreated($message = 'Resource created successfully!')
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respondWithSuccess($message);
    }

    /**
     * @param $message
     *
     * @return JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'status' => $this->getStatusCode(),
            'errors' => $message,
        ]);
    }

    /**
     * @param $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respondWithSuccess($message, $headers = [])
    {
        $message = ['status' => $this->getStatusCode(), 'data' => $message];

        if (isset($message['data']['pagination']['total'])) {
            $headers['X-Total-Count'] = $message['data']['pagination']['total'];
            $headers['Access-Control-Expose-Headers'] = 'X-Total-Count';
        }

        return $this->respond($message, $headers);
    }

    /**
     * @param $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return new JsonResponse($data, $this->getStatusCode(), $this->addAccessControlHeaders($headers));
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondConflict($message = 'conflict!')
    {
        return $this->setStatusCode(Response::HTTP_CONFLICT)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondNotAllowed($message = 'Not acceptable!')
    {
        return $this->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondAlreadyReported($message = 'Resource created successfully!')
    {
        return $this->setStatusCode(Response::HTTP_ALREADY_REPORTED)->respondWithSuccess($message);
    }

    /**
     * Add access control headers.
     *
     * @return array
     */
    private function addAccessControlHeaders(array $headers)
    {
        return array_merge($headers, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Methods' => 'GET,HEAD,OPTIONS,POST,PUT',
            'Access-Control-Allow-Headers' => 'Access-Control-Allow-Origin,Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers',
        ]);
    }

    /**
     * Get json request content.
     *
     * @return JsonResponse|array
     */
    public function getJsonRequestContent(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param array $list
     *
     * @return mixed
     */
    public function jsonDecodeAndValidate(Request $request, $list = [])
    {
        $json = json_decode($request->getContent());
        foreach ($list as $l) {
            if (!isset($json->{$l})) {
                throw new CustomBadException('bad Parameters');
            }
        }

        return $json;
    }
}
