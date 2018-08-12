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

    public $sl;

    public $sm;

    public $ss;

    public $st;

    public $thumb;

    public $original;

    public $standard;

    protected function getValidOffsets()
    {
        return self::KEYS;
    }
}
