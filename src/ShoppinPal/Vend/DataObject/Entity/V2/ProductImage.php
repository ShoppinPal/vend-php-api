<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\ArrayAccessEntity;
use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductImage extends EntityDoAbstract implements \ArrayAccess, \JsonSerializable
{
    use ArrayAccessEntity;

    const KEYS = [
        'id',
        'url',
        'sizes',
    ];

    protected $subEntities = [
        'sizes' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => ProductImageSize::class,
        ],
    ];

    /** @var string */
    public $id;
    /** @var string */
    public $url;
    /** @var ProductImageSize */
    public $sizes;
    /** @var int */
    public $version;

    protected function getValidOffsets()
    {
        self::KEYS;
    }
}
