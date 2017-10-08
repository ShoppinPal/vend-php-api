<?php

namespace ShoppinPal\Vend\Exception;

use YapepBase\Communication\CurlHttpRequestResult;

abstract class CommunicationException extends \YapepBase\Exception\Exception
{
    /** @var CurlHttpRequestResult  */
    protected $curlResult;

    /** @var string */
    protected $requestType;

    /**
     * V2CommunicationException constructor.
     *
     * @param string                $requestType
     * @param CurlHttpRequestResult $curlResult
     * @param string                $message
     * @param int                   $code
     * @param \Exception|null       $previous
     * @param null                  $data
     */
    public function __construct(
        $requestType,
        CurlHttpRequestResult $curlResult,
        $message,
        $code = 0,
        \Exception $previous = null,
        $data = null
    )
    {
        $this->curlResult = $curlResult;
        $this->requestType = $requestType;

        parent::__construct($message, $code, $previous, $data ?: $curlResult);
    }

    /**
     * @return string
     */
    protected function getStatusCodeLine(CurlHttpRequestResult $requestResult)
    {
        foreach (explode("\n", $requestResult->getResponseHeaders()) as $line) {
            if (preg_match('/^\s*HTTP\/\d\.\d (\d+.+)/', $line, $matches)) {
                return $matches[1];
            }
        }

        return (string)$requestResult->getResponseCode();
    }
}
