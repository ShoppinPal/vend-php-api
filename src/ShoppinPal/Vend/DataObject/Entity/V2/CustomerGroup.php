<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class CustomerGroup extends EntityDoAbstract
{
    public $id;

    public $name;

    public $groupId;

    public $version;

    public $createdAT;

    public $updatedAt;

    public $deletedAt;
}
