<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\Version;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Versions API
 */
class Versions extends V2ApiAbstract
{

    /**
     * Returns the latest versions of all versioned entities.
     *
     * @return Version
     */
    public function get()
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/versions', [], true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'versions get');

        return new Version($result['data'], Version::UNKNOWN_PROPERTY_IGNORE);
    }
}
