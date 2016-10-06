<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

class Customer extends CustomerSubEntity
{

    protected $subEntities = [
        'contact' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => ContactSubEntity::class,
        ],
    ];


    public $retailerId;

    public $firstName;

    public $lastName;

    public $companyName;

    public $email;

    public $phone;

    public $mobile;

    public $fax;

    public $loyaltyBalance;

    public $enableLoyalty;

    public $customField1;

    public $customField2;

    public $customField3;

    public $customField4;

    public $contactFirstName;

    public $contactLastName;

    /** @var ContactSubEntity */
    public $contact;
}
