<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class OutletAttribute extends EntityDoAbstract
{
    const KEY_ORDER_REFERENCE = 'order_reference';
    const KEY_ORDER_REFERENCE_PREFIX = 'order_reference_prefix';
    const KEY_RETURN_REFERENCE = 'return_reference';
    const KEY_RETURN_REFERENCE_PREFIX = 'return_reference_prefix';

    public $key;

    public $value;
}
