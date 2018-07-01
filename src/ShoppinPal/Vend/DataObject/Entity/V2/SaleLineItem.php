<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class SaleLineItem extends EntityDoAbstract
{

    protected $subEntities = [
        'taxComponents' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => SaleLineItemTaxComponent::class,
        ],
    ];

    public $id;

    public $productId;

    public $taxId;

    public $discountTotal;

    public $discount;

    public $priceTotal;

    public $price;

    public $costTotal;

    public $cost;

    public $taxTotal;

    public $tax;

    public $quantity;

    public $loyaltyValue;

    public $note;

    public $priceSet;

    public $status;

    public $sequence;

    /** @var SaleLineItemTaxComponent[] */
    public $taxComponents = [];

    public $unitCost;

    public $unitDiscount;

    public $unitLoyaltyValue;

    public $unitPrice;

    public $unitTax;

    public $totalCost;

    public $totalDiscount;

    public $totalLoyaltyValue;

    public $totalPrice;

    public $totalTax;

    public $isReturn;
}
