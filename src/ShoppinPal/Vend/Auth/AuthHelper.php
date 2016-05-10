<?php
namespace ShoppinPal\Vend\Auth;

use YapepBase\Communication\CurlHttpRequest;

/**
 * Helper for adding authentication information to a request.
 */
class AuthHelper
{

    /**
     * The token type.
     *
     * Usually 'Bearer'
     *
     * @var string
     */
    protected $tokenType;

    /**
     * The access token.
     *
     * Either an OAuth access token or a personal token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * AuthHelper constructor.
     *
     * @param string $tokenType   The token type.
     * @param string $accessToken The access token.
     */
    public function __construct($tokenType, $accessToken)
    {
        $this->tokenType = $tokenType;
        $this->accessToken = $accessToken;
    }

    /**
     * Adds an authorisation header with the authentication data to the request.
     *
     * @param CurlHttpRequest $request     The request
     *
     * @return void
     */
    public function addAuthorisationHeaderToRequest(CurlHttpRequest $request)
    {
        $request->addHeader('Authorization: ' . $this->tokenType . ' ' . $this->accessToken);
    }
}
