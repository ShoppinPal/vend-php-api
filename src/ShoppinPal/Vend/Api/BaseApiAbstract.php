<?php

namespace ShoppinPal\Vend\Api;

use ShoppinPal\Vend\Auth\AuthHelper;
use Vend\Exception\EntityNotFoundException;
use YapepBase\Application;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Exception\Exception;

/**
 * Base class for the API handlers.
 */
class BaseApiAbstract
{
    /** Collection order direction: ascending */
    const COLLECTION_ORDER_DIRECTION_ASC = 'ASC';

    /** Collection order direction: descending */
    const COLLECTION_ORDER_DIRECTION_DESC = 'DESC';

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
        $url =  sprintf(
            'https://%s.vendhq.com/%s%s',
            $this->domainPrefix,
            ltrim($path, '/'),
            empty($params) ? '' : ('?' . http_build_query($params))
        );
        
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
     * Sends the request to Vend, and reutrns the decoded JSON data from the response.
     *
     * @param CurlHttpRequest $request The request to send.
     *
     * @return array
     *
     * @throws Exception If there was an error while sending the request, or if invalid data is received from Vend.
     */
    protected function sendRequest(CurlHttpRequest $request)
    {
        $result = $request->send();

        if (!$result->getError() && 404 == $result->getResponseCode()) {
            throw new EntityNotFoundException('The specified entity can not be found', 404, null, $result);
        }

        if (!$result->isRequestSuccessful()) {
            throw new Exception('Error while sending request to Vend', 0, null, $result);
        }

        $resultData = json_decode($result->getResponseBody(), true);

        if (empty($resultData)) {
            throw new Exception('The data received from Vend is not JSON', 0, null, $result);
        }

        return $resultData;
    }
}
