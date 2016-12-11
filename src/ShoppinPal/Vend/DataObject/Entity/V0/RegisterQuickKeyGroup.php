<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterQuickKeyGroup extends EntityDoAbstract
{
    protected $subEntities = [
        'pages' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterQuickKeyPage::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_COLLECTION,
        ],

    ];

    public $name;

    public $position;

    /** @var RegisterQuickKeyPage[] */
    public $pages = [];
}
