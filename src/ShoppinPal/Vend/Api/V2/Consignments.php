<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Consignment;
use ShoppinPal\Vend\DataObject\Entity\V2\ConsignmentProduct;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Consignments API
 */
class Consignments extends V2ApiAbstract
{

    /**
     * @param int $pageSize
     * @param int $beforeVersion
     * @param int $afterVersion
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $beforeVersion = null,
        $afterVersion = null
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $beforeVersion, $afterVersion);

        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'consignment get collection');

        $consignments = [];

        foreach ($result['data'] as $consignment) {
            $consignments[] = new Consignment($consignment, Consignment::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $consignments
        );
    }

    /**
     * @param string $consignmentId
     *
     * @return Consignment
     *
     * @throws EntityNotFoundException
     */
    public function get($consignmentId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments/' . urlencode($consignmentId));

        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'consignment get');

        return new Consignment($result['data'], Consignment::UNKNOWN_PROPERTY_IGNORE, true);
    }

    /**
     * Returns a collection of products of the given consignment.
     *
     * @param string $consignmentId
     * @param int    $pageSize
     * @param int    $beforeVersion
     * @param int    $afterVersion
     *
     * @return CollectionResult
     */
    public function getProductCollection(
        $consignmentId,
        $pageSize = 50,
        $beforeVersion = null,
        $afterVersion = null
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $beforeVersion, $afterVersion);

        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments/' . urlencode($consignmentId) . '/products', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'consignment get product collection');

        $consignments = [];

        foreach ($result['data'] as $consignment) {
            $consignments[] = new ConsignmentProduct($consignment, ConsignmentProduct::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $consignments
        );
    }
}
