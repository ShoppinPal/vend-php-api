<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class PriceBookEntrySubEntity extends EntityDoAbstract
{

    public $id;

    public $productId;

    public $maxUnits;

    public $minUnits;

    public $price;

    public $tax;

    public $type;

    public $customerGroupId;

    public $customerGroupName;

    public $taxId;

    public $taxName;

    public $taxRate;
}
