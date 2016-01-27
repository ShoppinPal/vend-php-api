<?php

namespace ShoppinPal\Vend\Auth;

use ShoppinPal\Vend\DiHelper;
use YapepBase\Request\HttpRequest;
use YapepBase\View\ViewAbstract;

/**
 * Trait to be used by controllers to handle OAuth callbacks
 */
trait TOAuthCallback
{

    /**
     * Processes the callback to the oauth authorisation code request.
     *
     * @return string|ViewAbstract
     */
    protected function doOAuthAuthorisationCallback()
    {
        $code =         (string)$this->getRequest()->getGet('code');
        $domainPrefix = (string)$this->getRequest()->getGet('domain_prefix');
        $state =        (string)$this->getRequest()->getGet('state');
        $error =        (string)$this->getRequest()->getGet('error');

        if ($error) {
            return $this->processOAuthAuthorisationCallbackError($error);
        } else {
            $responseDo = $this->getOAuth()->requestAccessToken($domainPrefix, $code);
            return $this->processOAuthAuthorisationCallbackSuccess($responseDo, $domainPrefix, $state);
        }
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
     * Returns the current request instance.
     *
     * @return HttpRequest
     */
    abstract protected function getRequest();

    /**
     * Processes the error message callback received for an OAuth Authorisation call.
     *
     * @param string $errorMessage
     *
     * @return string|ViewAbstract
     */
    abstract protected function processOAuthAuthorisationCallbackError($errorMessage);

    /**
     * Processes the success message callback received for an OAuth Authorisation call.
     *
     * @param OAuthResponseDo $responseDo
     * @param                 $domainPrefix
     * @param                 $state
     *
     * @return string|ViewAbstract
     */
    abstract protected function processOAuthAuthorisationCallbackSuccess(
        OAuthResponseDo $responseDo,
        $domainPrefix,
        $state
    );
}
