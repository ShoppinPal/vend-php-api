<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class CustomerSubEntity extends EntityDoAbstract
{
    public $id;

    public $customerCode;

    public $balance;

    public $points;

    public $note;

    public $yearToDate;

    public $sex;

    public $dateOfBirth;

    public $updatedAt;

    public $createdAt;
}
