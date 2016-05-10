<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Product extends EntityDoAbstract{

    protected $subEntities = [
        'inventory' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => Inventory::class,
        ],
        'composites' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductComposite::class,
        ],
    ];

    public $id;

    public $sourceId;

    public $sourceVariantId;

    public $handle;

    public $type;

    public $tags;

    public $name;

    public $description;

    public $sku;

    public $variantOptionOneName;

    public $variantOptionOneValue;

    public $variantOptionTwoName;

    public $variantOptionTwoValue;

    public $variantOptionThreeName;

    public $variantOptionThreeValue;

    public $supplyPrice;

    public $retailPrice;

    public $tax;

    public $brandName;

    public $supplierName;

    public $supplierCode;

    public $inventory = [];

    public $composites = [];
}
