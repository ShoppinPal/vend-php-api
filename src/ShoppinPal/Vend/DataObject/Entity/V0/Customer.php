<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Customer extends EntityDoAbstract{

    public $id;

    public $name;

    public $customerCode;

    public $updatedAt;

    public $deletedAt;

    public $balance;

    public $yearToDate;

    public $points;

    public $customerGroupId;

    public $customerGroupName;

    public $companyName;

    public $phone;

    public $mobile;

    public $fax;

    public $email;

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
}
