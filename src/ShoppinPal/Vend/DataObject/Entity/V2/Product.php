<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Product extends EntityDoAbstract
{
    protected $subEntities = [
        'type' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => ProductType::class,
        ],
        'brand' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => Brand::class,
        ],
        'supplier' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
            self::SUB_ENTITY_KEY_CLASS => Supplier::class,
        ],
        'variantOptions' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductVariantOption::class,
        ],
        'images' => [
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_COLLECTION,
            self::SUB_ENTITY_KEY_CLASS => ProductImage::class,
        ]
    ];

    public $id;

    public $sourceId;

    public $sourceVariantId;

    public $variantParentId;

    public $name;

    public $variantName;

    public $handle;

    public $sku;

    public $supplierCode;

    public $active;

    public $hasInventory;

    public $isComposite;

    public $description;

    public $imageUrl;

    public $createdAt;

    public $updatedAt;

    public $deletedAt;

    public $source;

    public $accountCode;

    public $accountCodePurchase;

    public $supplyPrice;

    /** @var ProductType|null */
    public $type;

    /** @var Supplier|null */
    public $supplier;

    /** @var Brand|null */
    public $brand;

    /** @var ProductVariantOption[] */
    public $variantOptions = [];

    public $categories;

    /** @var ProductImage[] */
    public $images;

    public $hasVariants;

    public $buttonOrder;

    public $priceIncludingTax;

    public $priceExcludingTax;

    public $loyaltyAmount;

    public $supplierId;

    public $productTypeId;

    public $brandId;

    public $isActive;

    public $imageThumbnailUrl;

    public $tagIds;

    public $attributes;

    public $version;
}
