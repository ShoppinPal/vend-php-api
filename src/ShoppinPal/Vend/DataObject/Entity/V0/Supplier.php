<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;
use ShoppinPal\Vend\DataObject\Entity\V1\ContactSubEntity;

class Supplier extends EntityDoAbstract
{

    protected $subEntities = [
        self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        self::SUB_ENTITY_KEY_CLASS => ContactSubEntity::class,
    ];

    public $id;

    public $retailerId;

    public $name;

    public $description;

    public $source;

    /** @var ContactSubEntity */
    public $contact;
}
