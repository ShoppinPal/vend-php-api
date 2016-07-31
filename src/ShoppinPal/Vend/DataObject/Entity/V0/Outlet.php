<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Outlet extends EntityDoAbstract
{

    protected $subEntities = [
        'contact' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => Contact::class,
        ],
    ];

    public $id;

    public $email;

    public $name;

    public $physicalAddress1;

    public $physicalAddress2;

    public $physicalCity;

    public $physicalCountryId;

    public $physicalPostcode;

    public $physicalState;

    public $physicalSuburb;

    public $retailerId;

    public $timeZone;

    public $contact;
}
