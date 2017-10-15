<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class TaxRate extends EntityDoAbstract
{
    public $id;

    public $name;

    public $rate;

    public $displayName;
}
