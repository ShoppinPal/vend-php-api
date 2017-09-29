<?php
namespace ShoppinPal\Vend\Auth;

use YapepBase\Application;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Exception\Exception;

/**
 * Class for implementing the full OAuth process at Vend.
 */
class OAuth
{

    /**
     * The client ID for the application.
     *
     * @var string
     */
    protected $clientId;

    /**
     * The client secret for the application.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * The redirect URI for the application.
     *
     * @var string
     */
    protected $redirectUri;

    /**
     * OAuth constructor.
     *
     * @param string $clientId     The client ID for the application.
     * @param string $clientSecret The client secret for the application.
     * @param string $redirectUri  The redirect URI for the application.
     */
    public function __construct($clientId, $clientSecret, $redirectUri)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri  = $redirectUri;
    }

    /**
     * Returns the URL to redirect the user to initiate an authorisation.
     *
     * @param string $state
     *
     * @return string
     */
    public function getAuthorisationRedirectUrl($state)
    {
        $baseUrl = 'https://secure.vendhq.com/connect';
        $params  = [
            'response_type' => 'code',
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'state'         => $state,
        ];

        return $baseUrl . '?' . http_build_query($params);
    }

    /**
     * Requests an access token.
     *
     * @param string $domainPrefix The domain prefix for the Vend store.
     * @param string $code         The code received via a callback from Vend in the authorisation phase.
     *
     * @return OAuthResponseDo
     * @throws Exception                               If there is an error during the request.
     * @throws \YapepBase\Exception\CurlException      If there is a communication problem.
     * @throws \YapepBase\Exception\ParameterException If the response data is not in the required format.
     */
    public function requestAccessToken($domainPrefix, $code)
    {
        $params = [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->redirectUri,
        ];

        return $this->sendVendTokenRequest($domainPrefix, $params);
    }

    /**
     * Refreshes the specified access token.
     *
     * @param string $domainPrefix The domain prefix for the Vend store.
     * @param string $refreshToken The refresh token.
     *
     * @return OAuthResponseDo
     * @throws Exception                               If there is an error during the request.
     * @throws \YapepBase\Exception\CurlException      If there is a communication problem.
     * @throws \YapepBase\Exception\ParameterException If the response data is not in the required format.
     */
    public function refreshAccessToken($domainPrefix, $refreshToken)
    {
        $params = [
            'refresh_token' => $refreshToken,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type'    => 'refresh_token',
        ];

        return $this->sendVendTokenRequest($domainPrefix, $params);
    }

    /**
     * Refreshes the access token if it's expired.
     *
     * The callback will receive 1 parameter, which is an instance of OAuthResponseDo.
     *
     * @param \Closure $refreshCallback        The callback function to call if the token was refreshed.
     * @param string   $domainPrefix           The domain prefix.
     * @param int      $tokenExpiry            The expiry time of the token as a Unix timestamp.
     * @param string   $refreshToken           The refresh token.
     * @param int      $expiryThresholdSeconds If the token has less then this many seconds of life yet,
     *                                         then refresh it.
     *
     * @return void
     */
    public function refreshAccessTokenIfNeeded(
        \Closure $refreshCallback,
        $domainPrefix,
        $tokenExpiry,
        $refreshToken,
        $expiryThresholdSeconds = 0
    ) {
        if (($tokenExpiry - $expiryThresholdSeconds) > time()) {
            return;
        }

        $result = $this->refreshAccessToken($domainPrefix, $refreshToken);

        $refreshCallback($result);
    }

    /**
     * Adds an authorisation header with the OAuth data to the request.
     *
     * @param CurlHttpRequest $request     The request
     * @param string          $tokenType   The token type.
     * @param string          $accessToken The access token.
     *
     * @return void
     */
    public function addAuthorisationHeaderToRequest(CurlHttpRequest $request, $tokenType, $accessToken)
    {
        $request->addHeader('Authorization: ' . $tokenType . ' ' . $accessToken);
    }

    /**
     * Send a request to the Vend tokens endpoint.
     *
     * @param string $domainPrefix The domain prefix for the vend store.
     * @param array  $params       The parameters for the request.
     *
     * @return OAuthResponseDo
     * @throws Exception                               If there is an error during the request.
     * @throws \YapepBase\Exception\CurlException      If there is a communication problem.
     * @throws \YapepBase\Exception\ParameterException If the response data is not in the required format.
     */
    protected function sendVendTokenRequest($domainPrefix, array $params)
    {
        $url = 'https://' . $domainPrefix . '.vendhq.com/api/1.0/token';

        $request = Application::getInstance()->getDiContainer()->getCurlHttpRequest();
        $request->setMethod(CurlHttpRequest::METHOD_POST);
        $request->setUrl($url);
        $request->setPayload($params, CurlHttpRequest::PAYLOAD_TYPE_FORM_ENCODED);

        $result = $request->send();

        if (!$result->isRequestSuccessful()) {
            if ($result->getError()) {
                $additionalInfo = 'Curl error: ' . $result->getError();
            } else {
                $statusCode = $result->getResponseCode();
                preg_match(
                    '#^HTTP/[0-9\.]+ ' . (int)$statusCode . '[^\n]+#ms',
                    $result->getResponseHeaders(),
                    $matches
                );
                $additionalInfo = 'Status line: ' . $matches[0];
            }
            throw new Exception(
                'Error while sending the access token request for domain prefix: ' . $domainPrefix
                    . '. ' . $additionalInfo,
                0,
                null,
                $result
            );
        }

        $resultJson = json_decode($result->getResponseBody(), true);

        if (empty($resultJson)) {
            throw new Exception(
                'Error while decoding JSON response from the access token request for domain prefix: ' . $domainPrefix
                    . '. Error: ' . json_last_error_msg(),
                0,
                null,
                $result
            );
        }

        return new OAuthResponseDo($resultJson);
    }
}
