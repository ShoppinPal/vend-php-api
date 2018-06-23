<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\Brand;
use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Brands API
 */
class Brands extends V2ApiAbstract
{

    /**
     * Returns a collection of brands.
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
        $params = $this->getCollectionGetterParams($pageSize, $before, $after, $includeDeleted);

        $request = $this->getAuthenticatedRequestForUri('api/2.0/brands', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'brand get collection');

        $brands = [];

        foreach ($result['data'] as $brand) {
            $brands[] = new Brand($brand, Brand::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $brands
        );
    }
}
