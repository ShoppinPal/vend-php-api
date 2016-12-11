<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class User extends EntityDoAbstract
{

    protected $subEntities = [
        self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        self::SUB_ENTITY_KEY_CLASS => UserImage::class,
    ];

    public $id;

    public $username;

    public $name;

    public $email;

    public $outletId;

    public $outletName;

    public $outletIds;

    public $accountId;

    /** @var UserImage */
    public $image;
}
