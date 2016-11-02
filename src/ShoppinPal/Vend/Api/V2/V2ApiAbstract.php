<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\Exception\V2CommunicationException;

abstract class V2ApiAbstract extends BaseApiAbstract
{

    protected function getCommunicationExceptionClass()
    {
        return V2CommunicationException::class;
    }

}
