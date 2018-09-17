<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class ProductImageUpload extends EntityDoAbstract
{
	/** @var string */
    public $id;

    /** @var string */
    public $productId;

    /** @var int */
    public $position;

    /** @var string */
    public $status;

    /** @var int */
    public $version;
}
