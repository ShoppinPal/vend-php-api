<?php

namespace ShoppinPal\Vend\Exception;

use DateTime;
use YapepBase\Exception\Exception;

/**
 * Thrown if the request is denied because of rate limiting
 */
class RateLimitingException extends CommunicationException
{

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getRetryAfter()
    {
        $responseBody = $this->curlResult->getResponseBody();
        $decodedBody  = json_decode($responseBody, true);

        if (empty($decodedBody)) {
            throw new Exception('Unable to decode response body: ' . $responseBody);
        }

        if (!isset($decodedBody['retry-after'])) {
            throw new Exception('No retry-after in response body: ' . $responseBody);
        }

        $retryAfter = DateTime::createFromFormat(DateTime::RFC822, $decodedBody['retry-after']);

        if (empty($retryAfter)) {
            throw new Exception('Unable to parse date from retry-after string: ' . $decodedBody['retry-after']);
        }

        return $retryAfter;
    }
}
