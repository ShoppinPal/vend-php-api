<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Supplier;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Suppliers API
 */
class Suppliers extends V2ApiAbstract
{

    /**
     * Returns a collection of suppliers.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/suppliers', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'supplier get collection');

        $suppliers = [];

        foreach ($result['data'] as $supplier) {
            $suppliers[] = new Supplier($supplier, Supplier::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $suppliers
        );
    }

    /**
     * Returns the supplier, that matches this ID.
     *
     * @param string $supplierId ID of the supplier.
     *
     * @return Supplier
     *
     * @throws EntityNotFoundException If the supplier is not found.
     */
    public function get($supplierId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/suppliers/' . urlencode($supplierId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'supplier get');

        return new Supplier($result['data'], Supplier::UNKNOWN_PROPERTY_IGNORE, true);
    }
}
