<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\Outlet;
use YapepBase\Communication\CurlHttpRequest;

class Outlets extends V0ApiAbstract
{

    /**
     * Returns all registers
     *
     * @return Outlet[]
     * @throws \ShoppinPal\Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/outlets');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'outlet get all');

        $outlets = [];

        foreach ($result['outlets'] as $outlet) {
            $outlets[] = new Outlet($outlet, Outlet::UNKNOWN_PROPERTY_IGNORE);
        }

        return $outlets;
    }
}
