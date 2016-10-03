<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductPriceBookEntry extends EntityDoAbstract{

    public $id;

    public $productId;

    public $priceBookId;

    public $priceBookName;

    public $outletName;

    public $outletId;

    public $customerGroupName;

    public $customerGroupId;

    public $price;

    public $loyaltyValue;

    public $tax;

    public $taxId;

    public $taxRate;

    public $displayRetailPriceTaxInclusive;

    public $minUnits;

    public $maxUnits;

    public $validFrom;

    public $validTo;
}
