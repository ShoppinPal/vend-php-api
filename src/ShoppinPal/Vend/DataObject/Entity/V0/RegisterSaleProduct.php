<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

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
    
    public $name;

    public $quantity;

    public $price;

    public $tax;

    public $taxId;

    public $taxRate;
    
    public $taxTotal;

    public $priceTotal;

    public $displayRetailPriceTaxInclusive;

    public $attributes = [];
}
