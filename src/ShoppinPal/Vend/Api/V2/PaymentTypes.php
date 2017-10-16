<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\PaymentType;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 PaymentTypes API
 */
class PaymentTypes extends V2ApiAbstract
{

    /**
     * Returns a collection of payment types.
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

        $request = $this->getAuthenticatedRequestForUri('api/2.0/payment_types', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'payment type get collection');

        $paymentTypes = [];

        foreach ($result['data'] as $paymentType) {
            $paymentTypes[] = new PaymentType($paymentType, PaymentType::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $paymentTypes
        );
    }
}
