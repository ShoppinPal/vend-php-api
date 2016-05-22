<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductSubEntity extends EntityDoAbstract
{
    public $id;

    public $sku;

    public $handle;

    public $source;

    public $sourceId;

    public $active;

    public $name;

    public $description;
}
