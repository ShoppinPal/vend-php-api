<?php

namespace ShoppinPal\Vend\Auth;

use ShoppinPal\Vend\DiHelper;
use YapepBase\Request\HttpRequest;

/**
 * Trait to be used by controllers to handle OAuth callbacks
 */
trait TOAuthCallback
{

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * Processes the callback to the oauth authorisation code request.
     *
     * @return string
     */
    protected function doOAuthAuthorisationCallback()
    {
        $code         = (string)$this->request->getGet('code');
        $domainPrefix = (string)$this->request->getGet('domain_prefix');
        $state        = (string)$this->request->getGet('state');
        $error        = (string)$this->request->getGet('error');

        if ($error) {
            $this->processOAuthAuthorisationCallbackError($error);
        } else {
            $responseDo = $this->getOAuth()->requestAccessToken($domainPrefix, $code);
            $this->processOAuthAuthorisationCallbackSuccess($responseDo, $domainPrefix, $state);
        }

        return 'OK';
    }

    /**
     * Returns an instance of OAuth.
     *
     * @return OAuth
     */
    protected function getOAuth()
    {
        return DiHelper::getInstance()->getFactory()->getOAuth();
    }


    /**
     * Processes the error message callback received for an OAuth Authorisation call.
     *
     * @param string $errorMessage
     *
     * @return void
     */
    abstract protected function processOAuthAuthorisationCallbackError($errorMessage);

    /**
     * Processes the success message callback received for an OAuth Authorisation call.
     *
     * @param OAuthResponseDo $responseDo
     * @param                 $domainPrefix
     * @param                 $state
     *
     * @return mixed
     */
    abstract protected function processOAuthAuthorisationCallbackSuccess(OAuthResponseDo $responseDo, $domainPrefix, $state);
}
