<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductImageUpload extends EntityDoAbstract
{
    public $id;

    public $productId;

    public $position;

    public $status;

    public $version;
}
