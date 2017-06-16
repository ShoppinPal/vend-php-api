<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Inventory as InventoryEntity;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Inventory API
 */
class Inventory extends V2ApiAbstract
{

    /**
     * Returns a collection of inventory records.
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
        $params = [
            'page_size' => $pageSize,
        ];

        if (!empty($before)) {
            $params['before'] = $before;
        }

        if (!empty($after)) {
            $params['after'] = $after;
        }

        $request = $this->getAuthenticatedRequestForUri('api/2.0/inventory', $params, true);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'inventory get collection');

        $inventory = [];

        foreach ($result['data'] as $inventoryRecord) {
            $inventory[] = new InventoryEntity($inventoryRecord, InventoryEntity::UNKNOWN_PROPERTY_IGNORE);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $inventory
        );
    }
}
