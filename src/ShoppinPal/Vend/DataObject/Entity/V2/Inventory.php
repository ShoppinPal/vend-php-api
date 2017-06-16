<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Inventory extends EntityDoAbstract
{
    public $id;

    public $productId;

    public $outletId;

    public $inventoryLevel;

    public $reorderPoint;

    public $reorderAmount;

    public $deletedAt;

    public $version;
}
