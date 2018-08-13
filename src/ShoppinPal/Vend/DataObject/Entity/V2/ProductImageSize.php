<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\ArrayAccessEntity;
use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductImageSize extends EntityDoAbstract implements \ArrayAccess, \JsonSerializable
{
    use ArrayAccessEntity;

    const KEYS = [
        'sl',
        'sm',
        'ss',
        'st',
        'thumb',
        'original',
        'standard',
    ];

    /** @var string */
    public $sl;
    /** @var string */
    public $sm;
    /** @var string */
    public $ss;
    /** @var string */
    public $st;
    /** @var string */
    public $thumb;
    /** @var string */
    public $original;
    /** @var string */
    public $standard;

    protected function getValidOffsets()
    {
        return self::KEYS;
    }
}
