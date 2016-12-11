<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\Supplier;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V0 Suppliers API
 */
class Suppliers extends V0ApiAbstract
{
    /** Collection ordering: ID */
    const COLLECTION_ORDER_BY_ID = 'id';

    /** Collection ordering: updated_at */
    const COLLECTION_ORDER_BY_UPDATED_AT = 'updated_at';

    /** Collection ordering: name */
    const COLLECTION_ORDER_BY_NAME = 'name';

    /**
     * Returns all suppliers.
     *
     * @return Suppliers[]
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/supplier');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'supplier get all');

        $suppliers = [];

        foreach ($result['suppliers'] as $supplier) {
            $suppliers[] = new Supplier($supplier, Supplier::UNKNOWN_PROPERTY_IGNORE);
        }

        return $suppliers;
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
        $request = $this->getAuthenticatedRequestForUri('api/supplier/' . urlencode($supplierId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'supplier get');

        return new Supplier($result, Supplier::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Creates the specified supplier, and returns the Supplier instance that represents it.
     *
     * @param Supplier $supplier The supplier to create.
     *
     * @return Supplier
     */
    public function create(Supplier $supplier)
    {
        $modifiedSupplier     = clone($supplier);
        $modifiedSupplier->id = null;

        return $this->sendPostRequest($supplier, 'create');
    }

    /**
     * Updates the specified supplier, and returns the Supplier instance that represents the updated supplier.
     *
     * @param string  $supplierId ID of the supplier.
     * @param Supplier $supplier   The new data to set for the supplier.
     *
     * @return Supplier
     *
     * @throws EntityNotFoundException If the supplier is not found.
     */
    public function update($supplierId, Supplier $supplier)
    {
        $modifiedSupplier     = clone($supplier);
        $modifiedSupplier->id = $supplierId;

        return $this->sendPostRequest($modifiedSupplier, 'update');
    }

    /**
     * Sends a post request (update or create) for a supplier.
     *
     * @param Supplier $supplier
     * @param string   $action
     *
     * @return Supplier
     */
    protected function sendPostRequest(Supplier $supplier, $action)
    {
        $request = $this->getAuthenticatedRequestForUri('api/supplier');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($supplier->toUnderscoredArray([], true)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'supplier ' . $action);

        return new Supplier($result, Supplier::UNKNOWN_PROPERTY_IGNORE);
    }

    /**
     * Deletes a supplier
     *
     * @param string $supplierId ID of the supplier
     *
     * @return void
     */
    public function delete($supplierId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/supplier/' . urlencode($supplierId));
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $this->sendRequest($request, 'supplier delete');
    }
}
