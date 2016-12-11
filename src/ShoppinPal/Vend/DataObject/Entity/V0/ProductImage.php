<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductImage extends EntityDoAbstract
{

    protected $subEntities = [
        self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_SINGLE,
        self::SUB_ENTITY_KEY_CLASS => ProductImageLinks::class,
    ];
    public $id;

    /** @var ProductImageLinks */
    public $links;
}
