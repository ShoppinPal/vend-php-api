<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Sale extends EntityDoAbstract
{

    const STATUS_OPEN = 'OPEN';
    const STATUS_SAVED = 'SAVED';
    const STATUS_CLOSED = 'CLOSED';
    const STATUS_LAYBY = 'LAYBY';
    const STATUS_LAYBY_CLOSED = 'LAYBY_CLOSED';
    const STATUS_ONACCOUNT = 'ONACCOUNT';
    const STATUS_ONACCOUNT_CLOSED = 'ONACCOUNT_CLOSED';
    const STATUS_VOIDED = 'VOIDED';

    protected $subEntities = [
        'lineItems' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => SaleLineItem::class,
        ],
        'payments' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => SalePayment::class,
        ],
        'taxes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => SaleTax::class,
        ],
    ];

    public $id;

    public $outletId;

    public $registerId;

    public $userId;

    public $customerId;

    public $invoiceNumber;

    public $status;

    public $note;

    public $shortCode;

    public $returnFor;

    public $totalPrice;

    public $totalTax;

    public $totalLoyalty;

    public $createdAt;

    public $updatedAt;

    public $saleDate;

    public $deletedAt;

    /** @var SaleLineItem[] */
    public $lineItems = [];

    /** @var SalePayment[] */
    public $payments = [];

    public $version;

    public $receiptNumber;

    /** @var SaleTax */
    public $taxes = [];
}
