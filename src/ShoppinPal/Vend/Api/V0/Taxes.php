<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\Tax;
use YapepBase\Communication\CurlHttpRequest;

class Taxes extends V0ApiAbstract
{
    /**
     * Returns all taxes
     *
     * @return Tax[]
     * @throws \ShoppinPal\Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/taxes');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'tax get all');

        $registers = [];

        foreach ($result['taxes'] as $tax) {
            $registers[] = new Tax($tax, Tax::UNKNOWN_PROPERTY_IGNORE);
        }

        return $registers;
    }
}
