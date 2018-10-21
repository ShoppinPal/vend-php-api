<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\ProductType;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Product Types API
 */
class ProductTypes extends V2ApiAbstract
{

    /**
     * Returns a collection of product types.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/product_types', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product type get collection');

        $productTypes = [];

        foreach ($result['data'] as $productType) {
            $productTypes[] = new ProductType($productType, ProductType::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $productTypes
        );
    }

    /**
     * Returns the product type, that matches this ID.
     *
     * @param string $productTypeId ID of the product type.
     *
     * @return ProductType
     *
     * @throws EntityNotFoundException If the product type is not found.
     */
    public function get($productTypeId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/product_types/' . urlencode($productTypeId));

        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product type get');

        return new ProductType($result['data'], ProductType::UNKNOWN_PROPERTY_IGNORE, true);

    }

    /**
     * Creates the specified product type, and returns the Tag instance that represents it.
     *
     * @param ProductType $productType The product type to create.
     *
     * @return ProductType
     */
    public function create(ProductType $productType)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/product_types');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($productType->toUnderscoredArray()), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'product type create');

        return new ProductType($result['data'], ProductType::UNKNOWN_PROPERTY_IGNORE, true);
    }

}
