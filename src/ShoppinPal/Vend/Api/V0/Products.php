<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V0\Product;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V0 Products API
 */
class Products extends V0ApiAbstract
{
    /** Collection ordering: ID */
    const COLLECTION_ORDER_BY_ID = 'id';

    /** Collection ordering: updated_at */
    const COLLECTION_ORDER_BY_UPDATED_AT = 'updated_at';

    /** Collection ordering: name */
    const COLLECTION_ORDER_BY_NAME = 'name';

    /**
     * Returns a collection of products.
     *
     * @param int    $pageSize       The number of items to return per page.
     * @param int    $page           The page number.
     * @param string $orderBy        The field used to order by. {@uses self::COLLECTION_ORDER_BY_*}
     * @param string $orderDirection The order direction. {@uses self::COLLECTION_ORDER_DIRECTION_*}
     * @param bool   $active         TRUE: only active products are returned, FALSE: only inactive products are
     *                               returned, NULL: not filtering on active
     * @param string $sku            If set, only products matching this SKU will be returned.
     * @param string $handle         If set, only products matching this handle will be returned.
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $page = 1,
        $orderBy = self::COLLECTION_ORDER_BY_ID,
        $orderDirection = self::COLLECTION_ORDER_DIRECTION_ASC,
        $active = null,
        $sku = null,
        $handle = null
    )
    {
        $params = [
            'order_by'        => $orderBy,
            'page'            => $page,
            'page_size'       => $pageSize,
            'order_direction' => $orderDirection,
        ];

        if (false === $active) {
            $params['active'] = 0;
        } elseif (true === $active) {
            $params['active'] = 1;
        }

        if (!empty($sku)) {
            $params['sku'] = $sku;
        }

        if (!empty($handle)) {
            $params['handle'] = $handle;
        }

        $request = $this->getAuthenticatedRequestForUri('api/products', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product get collection');

        $products = [];

        foreach ($result['products'] as $product) {
            $products[] = new Product($product, Product::UNKNOWN_PROPERTY_IGNORE);
        }

        if (!isset($result['pagination'])) {
            $result['pagination'] = [
                'results'   => count($products),
                'page'      => $page,
                'page_size' => $pageSize,
                'pages'     => 1,
            ];
        }

        return new CollectionResult(
            $result['pagination']['results'],
            $result['pagination']['page'],
            $result['pagination']['page_size'],
            $result['pagination']['pages'],
            $products
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
        $request = $this->getAuthenticatedRequestForUri('api/products/' . urlencode($productId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'product get');

        return new Product($result['products'], Product::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Creates the specified product, and returns the Product instance that represents it.
     *
     * @param Product $product The product to create.
     *
     * @return Product
     */
    public function create(Product $product)
    {
        $modifiedProduct = clone($product);
        $modifiedProduct->id = null;

        $request = $this->getAuthenticatedRequestForUri('api/products');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($modifiedProduct->toUnderscoredArray([], true)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'product create');

        return new Product($result['product'], Product::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Updates the specified product, and returns the Product instance that represents the updated product.
     *
     * @param string  $productId ID of the product.
     * @param Product $product   The new data to set for the product.
     *
     * @return Product
     *
     * @throws EntityNotFoundException If the product is not found.
     */
    public function update($productId, Product $product)
    {
        $modifiedProduct = clone($product);
        $modifiedProduct->id = $productId;

        $request = $this->getAuthenticatedRequestForUri('api/products');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($modifiedProduct->toUnderscoredArray([], true)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'product update');

        return new Product($result['product'], Product::UNKNOWN_PROPERTY_IGNORE);
    }
}
