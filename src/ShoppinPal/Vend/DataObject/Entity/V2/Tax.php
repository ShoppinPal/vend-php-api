<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Tax extends EntityDoAbstract
{
    protected $subEntities = [
        'rates' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => TaxRate::class,
        ],
    ];

    public $id;

    public $name;

    public $isDefault;

    public $displayName;

    public $rates = [];

    public $deletedAt;

    public $version;
}
