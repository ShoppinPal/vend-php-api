<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Outlet extends EntityDoAbstract
{
    const DISPLAY_PRICES_INCLUSIVE = 'inclusive';
    const DISPLAY_PRICES_EXCLUSIVE = 'exclusive';

    protected $subEntities = [
        '$attributes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => OutletAttribute::class,
        ],
    ];

    public $id;

    public $name;

    public $defaultTaxId;

    public $currency;

    public $currencySymbol;

    public $displayPrices;

    public $timeZone;

    public $physicalAddress1;

    public $physicalAddress2;

    public $physicalSuburb;

    public $physicalCity;

    public $physicalPostcode;

    public $physicalState;

    public $physicalCountryId;

    public $deletedAt;

    public $version;

    /** @var OutletAttribute[] */
    public $attributes = [];
}
