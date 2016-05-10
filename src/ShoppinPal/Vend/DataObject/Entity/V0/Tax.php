<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Tax extends EntityDoAbstract
{
    public $id;

    public $tax;

    public $name;

    public $rate;
}
