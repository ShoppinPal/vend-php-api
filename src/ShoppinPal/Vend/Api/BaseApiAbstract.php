<?php

namespace ShoppinPal\Vend\Api;

use ShoppinPal\Vend\Auth\AuthHelper;
use ShoppinPal\Vend\Exception\CommunicationException;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use ShoppinPal\Vend\Exception\RateLimitingException;
use YapepBase\Application;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Config;

/**
 * Base class for the API handlers.
 */
abstract class BaseApiAbstract
{
    /** Collection order direction: ascending */
    const COLLECTION_ORDER_DIRECTION_ASC = 'ASC';

    /** Collection order direction: descending */
    const COLLECTION_ORDER_DIRECTION_DESC = 'DESC';

    // API version constants
    const API_VERSION_0 = 'V0';
    const API_VERSION_1 = 'V1';
    const API_VERSION_2 = 'V2';


    /**
     * @var AuthHelper
     */
    protected $authHelper;

    /**
     * @var string
     */
    protected $domainPrefix;

    /**
     * Products constructor.
     *
     * @param AuthHelper $authHelper   The auth helper instance.
     * @param string     $domainPrefix The domain prefix for the store.
     */
    public function __construct(AuthHelper $authHelper, $domainPrefix)
    {
        $this->authHelper = $authHelper;
        $this->domainPrefix = $domainPrefix;
    }

    /**
     * Returns the URL to call.
     *
     * @param string $path     The URI for the request.
     * @param array  $params   The GET params for the request as an associative array.
     *
     * @return string
     */
    protected function getUrl($path, array $params)
    {
        $vendUrl     = Config::getInstance()->get('resource.vend.url', '');
        $uri         = ltrim($path, '/');
        $queryString = empty($params) ? '' : ('?' . http_build_query($params));

        if (empty($vendUrl)) {
            $url =  sprintf(
                'https://%s.vendhq.com/%s%s',
                $this->domainPrefix,
                $path,
                $queryString
            );
        }
        else {
            $vendUrl = rtrim($vendUrl, '/') . '/';
            $url     = $vendUrl . $uri . $queryString;
        }

        return $url;
    }

    /**
     * Returns an authenticated CURL request to the Vend store with the specified path with the passed GET params.
     *
     * @param string $path            The URI for the request.
     * @param array  $params          The GET params for the request as an associative array.
     * @param bool   $skipContentType If TRUE, the Content-Type header will not be set.
     *
     * @return CurlHttpRequest
     */
    protected function getAuthenticatedRequestForUri($path, array $params = [], $skipContentType = false)
    {
        $url =  $this->getUrl($path, $params);
        
        $request = Application::getInstance()->getDiContainer()->getCurlHttpRequest();
        $request->setUrl($url);
        $request->addHeader('User-Agent: Shoppinpal Vend PHP API v0.1.0');
        if (!$skipContentType) {
            $request->addHeader('Content-Type: application/json');
        }
        $this->authHelper->addAuthorisationHeaderToRequest($request);

        return $request;
    }

    /**
     * Sends the request to Vend, and returns the decoded JSON data from the response.
     *
     * @param CurlHttpRequest $request The request to send.
     *
     * @param                 $requestType
     *
     * @return array|null
     * @throws EntityNotFoundException
     * @throws RateLimitingException
     * @throws CommunicationException
     */
    protected function sendRequest(CurlHttpRequest $request, $requestType)
    {
        $result = $request->send();

        if (!$result->isRequestSuccessful()) {
            if (!$result->getError()) {
                switch ($result->getResponseCode()) {
                    case 404:
                        throw new EntityNotFoundException('The specified entity can not be found', 404, null, $result);

                    case 429:
                        throw new RateLimitingException(
                            $requestType,
                            $result,
                            'Your access to the API has been rate limited',
                            429,
                            null
                        );
                }
            }

            $exceptionClass = $this->getCommunicationExceptionClass();
            throw new $exceptionClass($requestType, $result, 0, null);
        }

        if (204 == $result->getResponseCode()) {
            return null;
        }

        $resultData = json_decode($result->getResponseBody(), true);

        if (empty($resultData)) {
            $exceptionClass = $this->getCommunicationExceptionClass();
            throw new $exceptionClass($requestType, $result, 0, null);
        }

        return $resultData;
    }

    /**
     * Retuns the fully qualified class name of the communication exception to be thrown
     *
     * @return string
     */
    abstract protected function getCommunicationExceptionClass();
}
