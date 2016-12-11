<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterReceipt extends EntityDoAbstract
{
    protected $subEntities = [
        'fields' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterReceiptFields::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        ],

    ];

    /** @var RegisterReceiptFields */
    public $fields;
}
