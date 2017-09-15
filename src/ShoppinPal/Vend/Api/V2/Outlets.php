<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Outlet;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Outlets API
 */
class Outlets extends V2ApiAbstract
{

    /**
     * Returns a collection of outlets.
     *
     * @param int  $pageSize       The number of items to return per page.
     * @param null $before         The version to succeed the last returned version.
     * @param null $after          The version to precede the first returned version
     * @param bool $includeDeleted If TRUE, deleted items will be returned as well. (required to synchronise deletions)
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $before = null,
        $after = null,
        $includeDeleted = false
    )
    {
        $params = [
            'page_size' => $pageSize,
        ];

        if (!empty($before)) {
            $params['before'] = $before;
        }

        if (!empty($after)) {
            $params['after'] = $after;
        }

        if ($includeDeleted) {
            $params['deleted'] = 1;
        }

        $request = $this->getAuthenticatedRequestForUri('api/2.0/outlets', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'outlet get collection');

        $outlets = [];

        foreach ($result['data'] as $outlet) {
            $outlets[] = new Outlet($outlet, Outlet::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $outlets
        );
    }

    /**
     * Returns the outlet, that matches this ID.
     *
     * @param string $outletId ID of the outlet.
     *
     * @return Outlet
     *
     * @throws EntityNotFoundException If the outlet is not found.
     */
    public function get($outletId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/outlets/' . urlencode($outletId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'outlet get');

        return new Outlet($result['data'], Outlet::UNKNOWN_PROPERTY_IGNORE, true);
    }
}
