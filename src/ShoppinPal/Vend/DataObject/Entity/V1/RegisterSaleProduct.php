<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSaleProduct extends EntityDoAbstract
{
    protected $subEntities = [
        'attributes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleProductAttribute::class,
        ],
    ];

    public $id;

    public $productId;

    public $quantity;

    public $price;

    public $priceSet;

    public $tax;

    public $priceTotal;

    public $taxTotal;

    public $taxId;

    public $taxName;

    public $taxRate;

    /** @var RegisterSaleProductAttribute[] */
    public $attributes = [];
}
