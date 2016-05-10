<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSale extends EntityDoAbstract
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
        'registerSaleProducts' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleProduct::class,
        ],
        'totals' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleTotal::class,
        ],
        'registerSalePayments' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSalePayment::class,
        ],
        'taxes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => Tax::class,
        ],
    ];

    public $id;

    public $registerId;

    public $marketId;

    public $customerId;

    public $customerName;

    public $userId;

    public $userName;

    public $saleDate;

    public $totalPrice;

    public $totalTax;

    public $taxName;

    public $note;

    public $status;

    public $shortCode;

    public $invoiceNumber;

    public $invoiceSequence;

    /** @var RegisterSaleProduct[] */
    public $registerSaleProducts = [];

    /** @var  RegisterSaleTotal */
    public $totals;

    /** @var RegisterSalePayment[] */
    public $registerSalePayments = [];

    /** @var Tax[] */
    public $taxes = [];
}
