<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Supplier extends EntityDoAbstract
{

    public $id;

    public $name;

    public $source;

    public $description;

    public $deletedAt;

    public $version;
}
