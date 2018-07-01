<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Customer extends EntityDoAbstract
{

    const GENDER_MALE = 'M';

    const GENDER_FEMALE = 'F';

    public $id;

    public $customerCode;

    public $firstName;

    public $lastName;

    public $email;

    public $yearToDate;

    public $balance;

    public $loyaltyBalance;

    public $note;

    public $gender;

    public $dateOfBirth;

    public $companyName;

    public $doNotEmail;

    public $loyaltyEmailSent;

    public $phone;

    public $mobile;

    public $fax;

    public $twitter;

    public $website;

    public $physicalSuburb;

    public $physicalCity;

    public $physicalPostcode;

    public $physicalState;

    public $physicalAddress1;

    public $physicalAddress2;

    public $physicalCountryId;

    public $postalAddress1;

    public $postalAddress2;

    public $postalSuburb;

    public $postalCity;

    public $postalPostcode;

    public $postalState;

    public $postalCountryId;

    public $customerGroupId;

    public $enableLoyalty;

    public $createdAt;

    public $updatedAt;

    public $deletedAt;

    public $version;

    public $name;

    public $customField1;

    public $customField2;

    public $customField3;

    public $customField4;
}
