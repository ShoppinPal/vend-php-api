<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;
use YapepBase\Exception\ParameterException;

class Version extends EntityDoAbstract
{
    public $buttonLayouts;

    public $customerGroups;

    public $brands;

    public $productTypes;

    public $suppliers;

    public $retailer;

    public $priceBooks;

    public $outlets;

    public $taxes;

    public $paymentTypes;

    public $inventory;

    public $sales;

    public $users;

    public $tags;

    public $outletTaxes;

    public $products;

    public $priceBookProducts;

    public $registers;

    public $customers;

    public $consignments;

    /**
     * Returns TRUE if there is a newer version of the given entity.
     *
     * Since Vend recently changed this endpoint's behaviour and now returns a version of 1 if the retailer has no
     * entities for an entity type instead of 0, we will not consider any version less than 10 by default as a new
     * version (treat it as it has no entities for that type). Since the versions are typically much higher numbers
     * than 10 this should be safe to be left at 10, but can be overridden by the minimumVersion param.
     *
     * @param string   $entityType           The entity type. Must match one of the properties of this entity.
     * @param int|null $lastRetrievedVersion The last retrieved version
     * @param int      $minimumVersion       The minimum version number to be considered a new version
     *
     * @return bool
     *
     * @throws ParameterException If the entity type is invalid
     */
    public function hasNewerVersion(string $entityType, ?int $lastRetrievedVersion, int $minimumVersion = 10): bool
    {
        $invalidEntityTypes = [
            'subEntities',
            'ignoredProperties',
        ];

        $validEntityTypes = array_diff(array_keys(get_object_vars($this)), $invalidEntityTypes);

        if (!in_array($entityType, $validEntityTypes)) {
            throw new ParameterException('Invalid entity type: ' . $entityType);
        }

        return $lastRetrievedVersion > max($minimumVersion - 1, (int)$lastRetrievedVersion);
    }
}
