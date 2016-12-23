<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Customer;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Customers API
 */
class Customers extends V2ApiAbstract
{

    /**
     * Returns a collection of customers.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/customers', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'customer get collection');

        $customers = [];

        foreach ($result['data'] as $customer) {
            $customers[] = new Customer($customer, Customer::UNKNOWN_PROPERTY_IGNORE);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $customers
        );
    }

    /**
     * Returns the customer, that matches this ID.
     *
     * @param string $customerId ID of the customer.
     *
     * @return Customer
     *
     * @throws EntityNotFoundException If the customer is not found.
     */
    public function get($customerId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/customers/' . urlencode($customerId));

        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'customer get');

        return new Customer($result['data'], Customer::UNKNOWN_PROPERTY_IGNORE);

    }

    /**
     * Creates the specified customer, and returns the Customer instance that represents it.
     *
     * @param Customer $customer The customer to create.
     *
     * @return Customer
     */
    public function create(Customer $customer)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/customers');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $ignoredProperties = [
            'id',
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
        ];

        $request->setPayload(json_encode($customer->toUnderscoredArray($ignoredProperties)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'customer create');

        return new Customer($result['data'], Customer::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Updates the specified customer, and returns the Customer instance that represents the updated customer.
     *
     * @param string   $customerId ID of the customer
     * @param Customer $customer   The new data for the customer.
     *
     * @return Customer
     *
     * @throws EntityNotFoundException If the customer is not found.
     */
    public function update($customerId, Customer $customer)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/customers/' . urlencode($customerId));
        $request->setMethod(CurlHttpRequest::METHOD_PUT);

        $ignoredProperties = [
            'id',
            'createdAt',
            'updatedAt',
            'deletedAt',
            'version',
        ];

        $request->setPayload(json_encode($customer->toUnderscoredArray($ignoredProperties)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'customer update');

        return new Customer($result['data'], Customer::UNKNOWN_PROPERTY_IGNORE);

    }

    /**
     * Deletes the specified customer
     *
     * @param string $customerId
     *
     * @return void
     */
    public function delete($customerId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/customers/' . urlencode($customerId));
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $this->sendRequest($request, 'customer delete');
    }
}
