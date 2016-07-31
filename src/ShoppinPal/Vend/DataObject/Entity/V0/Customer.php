<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Customer extends EntityDoAbstract
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

    public $firstName;

    public $lastName;

    public $companyName;

    public $phone;

    public $mobile;

    public $fax;

    public $email;

    public $twitter;

    public $website;

    public $physicalAddress1;

    public $physicalAddress2;

    public $physicalSuburb;

    public $physicalCity;

    public $physicalPostcode;

    public $physicalState;

    public $physicalCountryId;

    public $postalAddress1;

    public $postalAddress2;

    public $postalSuburb;

    public $postalCity;

    public $postalPostcode;

    public $postalState;

    public $postalCountryId;

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

    public $contact;

    /** @deprecated This doesn't seem to be supported by Vend, and will be removed */
    public $points;
}
