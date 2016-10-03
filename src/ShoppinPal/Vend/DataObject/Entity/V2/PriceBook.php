<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class PriceBook extends EntityDoAbstract
{
    protected $subEntities = [
        'customerGroup' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => CustomerGroup::class,
        ],
    ];

    public $id;

    public $name;

    public $type;

    public $validFrom;

    public $validTo;

    public $restrictToPlayformKey;

    public $restrictToPlatformLabel;

    public $customerGroup;

    public $customerGroupId;

    public $outlet;

    public $outletId;

    public $version;

    public $deletedAt;
}
