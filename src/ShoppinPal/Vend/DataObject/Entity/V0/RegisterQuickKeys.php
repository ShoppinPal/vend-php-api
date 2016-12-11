<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterQuickKeys extends EntityDoAbstract
{
    protected $subEntities = [
        'groups' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterQuickKeyGroup::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_COLLECTION,
        ],

    ];

    /** @var RegisterQuickKeyGroup[] */
    public $groups = [];
}
