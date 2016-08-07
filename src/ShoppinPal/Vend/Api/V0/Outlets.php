<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\Outlet;
use YapepBase\Communication\CurlHttpRequest;

class Outlets extends BaseApiAbstract
{

    /**
     * Returns all registers
     *
     * @return Outlet[]
     * @throws \Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/outlets');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        $outlets = [];

        foreach ($result['outlets'] as $outlet) {
            $outlets[] = new Outlet($outlet, Outlet::UNKNOWN_PROPERTY_IGNORE);
        }

        return $outlets;
    }
}
