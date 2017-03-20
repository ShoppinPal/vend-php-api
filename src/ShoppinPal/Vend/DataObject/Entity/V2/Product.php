<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Product extends EntityDoAbstract
{

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

    public $version;

    public $type;

    public $supplier;

    public $brand;

    public $variantOptions;

    public $categories;

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
}
