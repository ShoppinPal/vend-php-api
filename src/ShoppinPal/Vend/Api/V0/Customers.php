<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V0\Customer;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V0 Customers API
 */
class Customers extends BaseApiAbstract
{
    /** Collection ordering: ID */
    const COLLECTION_ORDER_BY_ID = 'id';

    /** Collection ordering: updated_at */
    const COLLECTION_ORDER_BY_UPDATED_AT = 'updated_at';

    /** Collection ordering: name */
    const COLLECTION_ORDER_BY_NAME = 'name';

    /**
     * Returns a collection of customers.
     *
     * @param int    $pageSize       The number of items to return per page.
     * @param int    $page           The page number.
     * @param string $orderBy        The field used to order by. {@uses self::COLLECTION_ORDER_BY_*}
     * @param string $orderDirection The order direction. {@uses self::COLLECTION_ORDER_DIRECTION_*}
     * @param string $email          If set, only customers with this email will be returned.
     * @param string $code           If set, only customers with this code will be returned.
     * @param string $id             If set, only the customer with this ID will be returned.
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $page = 1,
        $orderBy = self::COLLECTION_ORDER_BY_ID,
        $orderDirection = self::COLLECTION_ORDER_DIRECTION_ASC,
        $email = null,
        $code = null,
        $id = null
    )
    {
        $params = [
            'order_by'        => $orderBy,
            'page'            => $page,
            'page_size'       => $pageSize,
            'order_direction' => $orderDirection,
        ];

        if (!empty($email)) {
            $params['email'] = $email;
        }

        if (!empty($code)) {
            $params['code'] = $code;
        }

        if (!empty($id)) {
            $params['id'] = $id;
        }

        $request = $this->getAuthenticatedRequestForUri('api/customers', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        $customers = [];

        foreach ($result['customers'] as $customer) {
            $customers[] = new Customer($customer, Customer::UNKNOWN_PROPERTY_IGNORE);
        }

        if (!isset($result['pagination'])) {
            $result['pagination'] = [
                'results'   => count($customers),
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
            $customers
        );
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
        $modifiedCustomer     = clone($customer);
        $modifiedCustomer->id = null;

        $request = $this->getAuthenticatedRequestForUri('api/customers');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($modifiedCustomer->toUnderscoredArray()), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request);

        return new Customer($result['customer'], Customer::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Updates the specified customer, and returns the Customer instance that represents the updated customer.
     *
     * @param string   $customerId ID of the customer
     * @param Customer $customer   The new data for the customer.
     *
     * @return Customer
     * @throws \Vend\Exception\EntityNotFoundException If the customer is not found.
     */
    public function update($customerId, Customer $customer)
    {
        $modifiedCustomer     = clone($customer);
        $modifiedCustomer->id = $customerId;

        $request = $this->getAuthenticatedRequestForUri('api/customers');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($modifiedCustomer->toUnderscoredArray()), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request);

        return new Customer($result['customer'], Customer::UNKNOWN_PROPERTY_IGNORE);
    }
}
