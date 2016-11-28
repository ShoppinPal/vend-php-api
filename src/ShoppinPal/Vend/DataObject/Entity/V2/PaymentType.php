<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class PaymentType extends EntityDoAbstract
{
    public $id;

    public $name;

    public $type_id;

    public $config;

    public $version;

    public $deletedAt;
}
