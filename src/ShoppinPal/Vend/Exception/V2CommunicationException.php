<?php

namespace ShoppinPal\Vend\Exception;

use YapepBase\Communication\CurlHttpRequestResult;

class V2CommunicationException extends CommunicationException
{
    /**
     * V2CommunicationException constructor.
     *
     * @param string                $requestType
     * @param CurlHttpRequestResult $curlResult
     * @param int                   $code
     * @param \Exception|null       $previous
     * @param null                  $data
     */
    public function __construct(
        $requestType,
        CurlHttpRequestResult $curlResult,
        $code = 0,
        \Exception $previous = null,
        $data = null
    )
    {
        $message = 'Error while sending ' . $requestType . ' request to Vend V2 API. ';

        if ($curlResult->getError()) {
            $message .= 'CURL error: ' . $curlResult->getError();
        } else {
            $message .= 'Received status code: ' . $this->getStatusCodeLine($curlResult) . '.';
            $decodedBody = json_decode($curlResult->getResponseBody(), true);

            if ($decodedBody) {
                if (isset($decodedBody['errors']) && isset($decodedBody['reference'])) {
                    $message .= ' Status: ' . $decodedBody['status'] . '. Error: ' . $decodedBody['error'] . '.';
                    if (isset($decodedBody['details'])) {
                        $message .= ' Details: ' .  $decodedBody['details'];
                    }
                } else {
                    $message .= 'Result JSON: ' . $curlResult->getResponseBody();
                }
            }
        }

        parent::__construct($requestType, $curlResult, $message, $code, $previous, $data);
    }
}
