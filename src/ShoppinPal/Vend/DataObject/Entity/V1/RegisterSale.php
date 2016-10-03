<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSale extends EntityDoAbstract
{
    protected $subEntities = [
        'totals' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleTotal::class,
        ],
        'customer' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => CustomerSubEntity::class,
        ],
        'user' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => UserSubEntity::class,
        ],
        'registerSaleProducts' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleProduct::class,
        ],
        'registerSalePayments' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSalePayment::class,
        ],
        'taxes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => TaxSubEntity::class,
        ],
    ];

    public $id;

    public $saleDate;

    public $status;

    public $userId;

    public $customerId;

    public $registerId;

    public $marketId;

    public $invoiceNumber;

    public $shortCode;

    /** @var RegisterSaleTotal */
    public $totals;

    public $note;

    public $updatedAt;

    public $createdAt;

    /** @var CustomerSubEntity */
    public $customer;

    /** @var UserSubEntity */
    public $user;

    /** @var RegisterSaleProduct[] */
    public $registerSaleProducts = [];

    /** @var RegisterSalePayment[] */
    public $registerSalePayments = [];

    /** @var TaxSubEntity[] */
    public $taxes = [];
}
