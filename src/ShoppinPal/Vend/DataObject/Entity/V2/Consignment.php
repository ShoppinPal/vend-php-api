<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Consignment extends EntityDoAbstract
{
    const TYPE_STOCK_ORDER    = 'SUPPLIER';
    const TYPE_RETURN         = 'RETURN';
    const TYPE_STOCK_TAKE     = 'STOCKTAKE';
    const TYPE_STOCK_TRANSFER = 'OUTLET';

    const STATUS_OPEN                             = 'OPEN';
    const STATUS_SENT                             = 'SENT';
    const STATUS_RECEIVED                         = 'RECEIVED';
    const STATUS_CANCELLED                        = 'CANCELLED';
    const STATUS_STOCK_TAKE_SCHEDULED             = 'STOCKTAKE_SCHEDULED';
    const STATUS_STOCK_TAKE_IN_PROGRESS_PROCESSED = 'STOCKTAKE_IN_PROGRESS_PROCESSED';
    const STATUS_STOCK_TAKE_COMPLETE              = 'STOCKTAKE_COMPLETE';

    protected $subEntities = [
        'filters' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ConsignmentFilter::class,
        ],
    ];

    public $id;
    public $outletId;
    public $name;
    public $dueAt;
    public $type;
    public $status;
    public $supplierId;
    public $sourceOutletId;
    public $consignmentDate;
    public $receivedAt;
    public $showInactive;
    public $supplierInvoice;
    public $reference;
    public $totalCountGain;
    public $totalCostGain;
    public $totalCountLoss;
    public $totalCostLoss;
    public $createdAt;
    public $updatedAt;
    public $deletedAt;
    public $version;

    /** @var ConsignmentFilter[] */
    public $filters = [];
}
