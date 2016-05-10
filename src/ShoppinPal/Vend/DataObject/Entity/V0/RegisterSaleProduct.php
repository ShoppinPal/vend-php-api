<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSaleProduct extends EntityDoAbstract
{
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
}
