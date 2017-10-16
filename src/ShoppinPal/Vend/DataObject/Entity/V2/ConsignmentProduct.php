<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ConsignmentProduct extends EntityDoAbstract
{
    const STATUS_PENDING           = 'PENDING';
    const STATUS_SENT_SUCCESS      = 'SENT_SUCCESS';
    const STATUS_RECEIVE_SUCCESS   = 'RECEIVE_SUCCESS';
    const STATUS_STOCKTAKE_SUCCESS = 'STOCKTAKE_SUCCESS';

    public $productId;
    public $productSku;
    public $count;
    public $received;
    public $cost;
    public $isIncluded;
    public $status;
    public $createdAt;
    public $updatedAt;
    public $deletedAt;
    public $version;
}
