<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class UserSubEntity extends EntityDoAbstract
{
    public $id;

    public $name;

    public $displayName;

    public $outletId;

    public $tagetDaily;

    public $targetWeekly;

    public $targetMonthly;

    public $createdAt;

    public $updatedAt;
}
