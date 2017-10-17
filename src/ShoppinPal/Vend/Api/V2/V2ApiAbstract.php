<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\Exception\V2CommunicationException;

abstract class V2ApiAbstract extends BaseApiAbstract
{

    protected function getCommunicationExceptionClass()
    {
        return V2CommunicationException::class;
    }

    /**
     * @param int   $pageSize
     * @param int   $beforeVersion
     * @param int   $afterVersion
     * @param bool $includeDeleted
     *
     * @return array
     */
    protected function getCollectionGetterParams($pageSize, $beforeVersion, $afterVersion, $includeDeleted = false)
    {
        $params = [
            'page_size' => $pageSize,
        ];

        if (!empty($beforeVersion)) {
            $params['before'] = $beforeVersion;
        }

        if (!empty($afterVersion)) {
            $params['after'] = $afterVersion;
        }

        if ($includeDeleted) {
            $params['deleted'] = 1;
        }

        return $params;
    }

}
