<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\CustomerGroup;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Customer Group API
 */
class CustomerGroups extends V2ApiAbstract
{

    /**
     * Returns a collection of customer group records.
     *
     * @param int  $pageSize       The number of items to return per page.
     * @param null $before         The version to succeed the last returned version.
     * @param null $after          The version to precede the first returned version
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $before = null,
        $after = null
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $before, $after);

        $request = $this->getAuthenticatedRequestForUri('api/2.0/customer_groups', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'customerGroup get collection');

        $customerGroup = [];

        foreach ($result['data'] as $record) {
            $customerGroup[] = new CustomerGroup($record, CustomerGroup::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $customerGroup
        );
    }
}
