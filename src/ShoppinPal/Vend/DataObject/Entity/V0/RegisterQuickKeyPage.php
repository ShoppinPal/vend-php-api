<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterQuickKeyPage extends EntityDoAbstract
{
    protected $subEntities = [
        'keys' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterQuickKey::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_COLLECTION,
        ],

    ];

    public $page;

    /** @var RegisterQuickKey[] */
    public $keys = [];
}
