<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ConsignmentFilter extends EntityDoAbstract
{
    const TYPE_BRAND        = 'brand';
    const TYPE_PRODUCT      = 'product';
    const TYPE_PRODUCT_TYPE = 'product_type';
    const TYPE_SUPPLIER     = 'supplier';
    const TYPE_TAG          = 'tag';

    public $id;
    public $type;
    public $value;
}
