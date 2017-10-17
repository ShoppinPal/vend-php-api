<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Product;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Products API
 */
class Products extends V2ApiAbstract
{

    /**
     * Returns a collection of products.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/products', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product get collection');

        $products = [];

        foreach ($result['data'] as $product) {
            $products[] = new Product($product, Product::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $products
        );
    }

    /**
     * Returns the product, that matches this ID.
     *
     * @param string $productId ID of the product.
     *
     * @return Product
     *
     * @throws EntityNotFoundException If the product is not found.
     */
    public function get($productId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/products/' . urlencode($productId));

        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product get');

        return new Product($result['data'], Product::UNKNOWN_PROPERTY_IGNORE, true);

    }
}
