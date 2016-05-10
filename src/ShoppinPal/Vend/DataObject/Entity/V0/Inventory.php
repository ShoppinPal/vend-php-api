<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Inventory extends EntityDoAbstract{

    public $outletName;

    public $count;

    public $reorderPoint;

    public $restockLevel;

}
