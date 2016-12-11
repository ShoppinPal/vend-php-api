<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;
use ShoppinPal\Vend\DataObject\Entity\V1\RegisterSaleProductAttribute;

class RegisterSaleProduct extends EntityDoAbstract
{
    const STATUS_CONFIRMED = 'CONFIRMED';

    protected $subEntities = [
        'attributes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => RegisterSaleProductAttribute::class,
        ],
    ];

    public $id;
    
    public $productId;

    public $registerId;

    public $sequence;

    public $handle;

    public $sku;
    
    public $name;

    public $quantity;

    public $price;

    public $cost;

    public $priceSet;

    public $discount;

    public $loyaltyValue;

    public $tax;

    public $taxId;

    public $taxRate;
    
    public $taxTotal;

    public $priceTotal;

    public $displayRetailPriceTaxInclusive;

    public $status;

    /** @var RegisterSaleProductAttribute[] */
    public $attributes = [];
}
