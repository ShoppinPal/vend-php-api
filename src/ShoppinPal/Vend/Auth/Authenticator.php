<?php

namespace ShoppinPal\Vend\Auth;

use YapepBase\Communication\CurlHttpRequest;

/**
 * Class for the simplified, personal token based auth at Vend.
 */
class Authenticator
{

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


}
