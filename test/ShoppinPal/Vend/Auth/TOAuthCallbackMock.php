<?php

namespace ShoppinPal\Vend\Auth;

class TOAuthCallbackMock
{

    use TOAuthCallback;

    /**
     * @var \Closure
     */
    public $errorCallback;

    /**
     * @var \Closure
     */
    public $successCallback;

    public $request;

    public function getRequest()
    {
        return $this->request;
    }

    public function runTest()
    {
        return $this->doOAuthAuthorisationCallback();
    }

    protected function processOAuthAuthorisationCallbackError($errorMessage)
    {
        return call_user_func($this->errorCallback, $errorMessage);
    }

    protected function processOAuthAuthorisationCallbackSuccess(OAuthResponseDo $responseDo, $domainPrefix, $state)
    {
        return call_user_func($this->successCallback, $responseDo, $domainPrefix, $state);

    }

}
