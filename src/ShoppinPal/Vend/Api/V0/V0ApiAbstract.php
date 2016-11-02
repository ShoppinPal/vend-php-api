<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\Exception\V0CommunicationException;

abstract class V0ApiAbstract extends BaseApiAbstract
{

    protected function getCommunicationExceptionClass()
    {
        return V0CommunicationException::class;
    }

}
