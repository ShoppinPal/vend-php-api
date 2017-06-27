<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Register;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Registers API
 */
class Registers extends V2ApiAbstract
{

    /**
     * Returns a collection of registers.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/registers', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'register get collection');

        $registers = [];

        foreach ($result['data'] as $register) {
            $registers[] = new Register($register, Register::UNKNOWN_PROPERTY_IGNORE);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $registers
        );
    }

    /**
     * Returns the register, that matches this ID.
     *
     * @param string $registerId ID of the register.
     *
     * @return Register
     *
     * @throws EntityNotFoundException If the register is not found.
     */
    public function get($registerId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/registers/' . urlencode($registerId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'register get');

        return new Register($result['data']);
    }
}
