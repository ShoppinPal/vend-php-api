<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterQuickKeysTemplate extends EntityDoAbstract
{
    protected $subEntities = [
        'quickKeys' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterQuickKeys::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        ],

    ];

    /** @var RegisterQuickKeys */
    public $quickKeys;
}
