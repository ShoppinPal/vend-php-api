<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class CustomerSubEntity extends EntityDoAbstract
{

    const SEX_MALE = 'M';

    const SEX_FEMALE = 'F';

    protected $subEntities = [
        'contact' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => CustomerContact::class,
        ],
    ];

    public $id;

    public $name;

    public $customerCode;

    public $customerGroupId;

    public $customerGroupName;

    public $updatedAt;

    public $deletedAt;

    public $balance;

    public $yearToDate;

    public $dateOfBirth;

    public $sex;

    public $customField1;

    public $customField2;

    public $customField3;

    public $customField4;

    public $note;

    /** @var CustomerContact */
    public $contact;
}
