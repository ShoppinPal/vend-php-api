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
     * @param bool $includeDeleted If TRUE, deleted items will be returned as well. (required to synchronise deletions)
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $beforeVersion = null,
        $afterVersion = null,
        $includeDeleted = false
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $beforeVersion, $afterVersion, $includeDeleted);

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
     * Creates the specified consignment, and returns the Consignment instance that represents it.
     *
     * @param Consignment $consignment The consignment to create.
     *
     * @return Consignment
     */
    public function create(Consignment $consignment)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $ignoredProperties = [
            'id',
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
        ];

        $request->setPayload(
            json_encode($consignment->toUnderscoredArray($ignoredProperties)),
            CurlHttpRequest::PAYLOAD_TYPE_RAW
        );

        $result = $this->sendRequest($request, 'consignment create');

        return new Consignment($result['data'], Consignment::UNKNOWN_PROPERTY_IGNORE, true);
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
     * Updates the specified consignment, and returns the Consignment instance that represents the updated consignment.
     *
     * @param string      $consignmentId ID of the consignment
     * @param Consignment $consignment   The new data for the consignment.
     *
     * @return Consignment
     *
     * @throws EntityNotFoundException If the consignment is not found.
     */
    public function update($consignmentId, Consignment $consignment)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments/' . urlencode($consignmentId));
        $request->setMethod(CurlHttpRequest::METHOD_PUT);

        $ignoredProperties = [
            'id',
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
        ];

        $request->setPayload(
            json_encode($consignment->toUnderscoredArray($ignoredProperties)),
            CurlHttpRequest::PAYLOAD_TYPE_RAW
        );

        $result = $this->sendRequest($request, 'consignment update');

        return new Consignment($result['data'], Consignment::UNKNOWN_PROPERTY_IGNORE, true);
    }

    /**
     * Deletes the specified consignment
     *
     * @param string $consignmentId
     *
     * @return void
     */
    public function delete($consignmentId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments/' . urlencode($consignmentId));
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $this->sendRequest($request, 'consignment delete');
    }
    /**
     * Returns a collection of products of the given consignment.
     *
     * @param string $consignmentId
     * @param int    $pageSize
     * @param int    $beforeVersion
     * @param int    $afterVersion
     * @param bool   $includeDeleted
     *
     * @return CollectionResult
     */
    public function getProductCollection(
        $consignmentId,
        $pageSize = 50,
        $beforeVersion = null,
        $afterVersion = null,
        $includeDeleted = false
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $beforeVersion, $afterVersion, $includeDeleted);

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

    /**
     * Adjusts (increases or decreases) the amount of the specified product in the consignment and returns the adjusted
     * ConsignmentProduct instance.
     *
     * If the product is not in the consignment, it will be created with the specified count. This method is designed to
     * be used for example in inventory counts, where you add 1 for each counted item, or a workflow where you add to
     * (or subtract from) the existing number of items in the consignment.
     *
     * @param string             $consignmentId
     * @param ConsignmentProduct $consignmentProduct
     *
     * @return ConsignmentProduct
     * @throws EntityNotFoundException
     * @throws \ShoppinPal\Vend\Exception\CommunicationException
     * @throws \ShoppinPal\Vend\Exception\RateLimitingException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\ParameterException
     */
    public function adjustProductCountInConsignment($consignmentId, ConsignmentProduct $consignmentProduct)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/consignments/' . urlencode($consignmentId) . '/products');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $ignoredProperties = [
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
            'isIncluded',
        ];

        $request->setPayload(
            json_encode($consignmentProduct->toUnderscoredArray($ignoredProperties)),
            CurlHttpRequest::PAYLOAD_TYPE_RAW
        );

        $result = $this->sendRequest($request, 'consignment product adjust');

        return new ConsignmentProduct($result['data'], ConsignmentProduct::UNKNOWN_PROPERTY_IGNORE, true);
    }

    /**
     * Sets the count of the specified to product in the consignment and returns the adjusted
     * ConsignmentProduct instance.
     *
     * This method sets the counts of the product (does not take into account any previous counts of the product). This
     * method is useful for workflows where you want to set the item count to a known number.
     *
     * @param string             $consignmentId
     * @param ConsignmentProduct $consignmentProduct
     *
     * @return ConsignmentProduct
     * @throws EntityNotFoundException
     * @throws \ShoppinPal\Vend\Exception\CommunicationException
     * @throws \ShoppinPal\Vend\Exception\RateLimitingException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\ParameterException
     */
    public function setProductCountInConsignment($consignmentId, ConsignmentProduct $consignmentProduct)
    {
        $request = $this->getAuthenticatedRequestForUri(
            'api/2.0/consignments/' . urlencode($consignmentId) . '/products/' . urlencode($consignmentProduct->productId)
        );
        $request->setMethod(CurlHttpRequest::METHOD_PUT);

        $ignoredProperties = [
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
            'isIncluded',
        ];

        $request->setPayload(
            json_encode($consignmentProduct->toUnderscoredArray($ignoredProperties)),
            CurlHttpRequest::PAYLOAD_TYPE_RAW
        );

        $result = $this->sendRequest($request, 'consignment product set');

        return new ConsignmentProduct($result['data'], ConsignmentProduct::UNKNOWN_PROPERTY_IGNORE, true);
    }

    /**
     * Deletes a product from a consignment.
     *
     * @param string $consignmentId
     * @param string $productId
     *
     * @return void
     * @throws EntityNotFoundException
     * @throws \ShoppinPal\Vend\Exception\CommunicationException
     * @throws \ShoppinPal\Vend\Exception\RateLimitingException
     * @throws \YapepBase\Exception\CurlException
     */
    public function deleteProductCountFromConsignment($consignmentId, $productId)
    {
        $request = $this->getAuthenticatedRequestForUri(
            'api/2.0/consignments/' . urlencode($consignmentId) . '/products/' . urlencode($productId)
        );
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $this->sendRequest($request, 'consignment product delete');

    }
}
