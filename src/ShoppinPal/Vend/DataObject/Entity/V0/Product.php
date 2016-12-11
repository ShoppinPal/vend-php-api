<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Product extends EntityDoAbstract
{

    protected $subEntities = [
        'images' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductImage::class,
        ],
        'inventory' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => Inventory::class,
        ],
        'composites' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductComposite::class,
        ],
        'priceBookEntries' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductPriceBookEntry::class,
        ],
        'taxes' => [
            self::SUB_ENTITY_KEY_TYPE => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductTax::class,
        ]
    ];

    public $id;

    public $sourceId;

    public $vairantSourceId;

    public $handle;

    public $type;

    public $hasVariants;

    public $variantParentId;

    public $variantOptionOneName;

    public $variantOptionOneValue;

    public $variantOptionTwoName;

    public $variantOptionTwoValue;

    public $variantOptionThreeName;

    public $variantOptionThreeValue;

    public $active;

    public $name;

    public $baseName;

    public $description;

    public $image;

    public $imageLarge;

    /** @var ProductImage[] */
    public $images = [];

    public $sku;

    public $tags;

    public $brandId;

    public $brandName;

    public $supplierName;

    public $supplierCode;

    public $supplyPrice;

    public $accountCodePurchase;

    public $accountCodeSales;

    public $trackInventory;

    public $buttonOrder;

    /** @var Inventory[] */
    public $inventory = [];

    /** @var ProductPriceBookEntry[] */
    public $priceBookEntries = [];

    /**
     * Alias to retailPrice
     *
     * @var float
     */
    public $price;

    public $retailPrice;

    public $tax;

    public $taxId;

    public $taxRate;

    public $taxName;

    /** @var ProductTax */
    public $taxes = [];

    public $updatedAt;

    public $deletedAt;

    /** @var ProductComposite[] */
    public $composites = [];
}
