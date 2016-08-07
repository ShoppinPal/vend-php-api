<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

class Tax extends TaxSubEntity
{

    protected $subEntities = [
        'rates' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => TaxRate::class,
        ],
    ];

    /** @var TaxRate[] */
    public $rates = [];

    /** @var bool */
    public $default;

    /** @var bool */
    public $active;
}
