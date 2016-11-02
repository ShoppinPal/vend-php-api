<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\PriceBook;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 PriceBooks API
 */
class PriceBooks extends V2ApiAbstract
{

    /**
     * Returns a collection of price books.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/price_books', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'price book get collection');

        $priceBooks = [];

        foreach ($result['data'] as $priceBook) {
            $priceBooks[] = new PriceBook($priceBook, PriceBook::UNKNOWN_PROPERTY_IGNORE);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $priceBooks
        );
    }

    /**
     * Returns the price book, that matches this ID.
     *
     * @param string $priceBookId ID of the price book.
     *
     * @return PriceBook
     *
     * @throws EntityNotFoundException If the price book is not found.
     */
    public function get($priceBookId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/price_books/' . urlencode($priceBookId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'price book get');

        return new PriceBook($result['data']);
    }

    /**
     * Creates the specified price book, and returns the PriceBook instance that represents it.
     *
     * @param PriceBook $priceBook The price book to create.
     *
     * @return PriceBook
     */
    public function create(PriceBook $priceBook)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/price_books');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($priceBook->toUnderscoredArray()), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'price book create');

        return new PriceBook($result['data'], PriceBook::UNKNOWN_PROPERTY_IGNORE);
    }
}
