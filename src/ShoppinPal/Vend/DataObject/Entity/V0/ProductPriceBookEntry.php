<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductPriceBookEntry extends EntityDoAbstract
{

    /** Base price book */
    const TYPE_BASE = 'BASE';

    /** General, customer created price book */
    const TYPE_GENERAL = 'GENERAL';

    public $id;

    public $productId;

    public $priceBookId;

    public $priceBookName;

    public $type;

    public $outletName;

    public $outletId;

    public $customerGroupName;

    public $customerGroupId;

    public $price;

    public $loyaltyValue;

    public $tax;

    public $taxId;

    public $taxRate;

    public $taxName;

    public $displayRetailPriceTaxInclusive;

    public $minUnits;

    public $maxUnits;

    public $validFrom;

    public $validTo;
}
