<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class InventorySubEntity extends EntityDoAbstract
{
    public $id;

    public $productId;

    public $outletId;

    public $attributedCost;

    public $count;

    public $reorderPoint;

    public $restockLevel;
}
