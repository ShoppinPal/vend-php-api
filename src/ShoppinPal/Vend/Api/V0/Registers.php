<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\Register;
use YapepBase\Communication\CurlHttpRequest;

class Registers extends BaseApiAbstract
{

    /**
     * Returns all registers
     *
     * @return Register[]
     * @throws \Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/registers');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        $registers = [];

        foreach ($result['registers'] as $register) {
            $registers[] = new Register($register, Register::UNKNOWN_PROPERTY_IGNORE);
        }

        return $registers;
    }
}
