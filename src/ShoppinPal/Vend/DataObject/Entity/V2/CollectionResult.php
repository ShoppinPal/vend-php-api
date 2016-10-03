<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class CollectionResult
{

    /**
     * @var int|null
     */
    public $minVersion;

    /**
     * @var int|null
     */
    public $maxVersion;

    /**
     * @var EntityDoAbstract[]
     */
    public $entities;

    /**
     * CollectionResult constructor.
     *
     * @param int|null           $minVersion
     * @param int|null           $maxVersion
     * @param EntityDoAbstract[] $entities
     */
    public function __construct($minVersion, $maxVersion, array $entities)
    {
        $this->minVersion = $minVersion;
        $this->maxVersion = $maxVersion;
        $this->entities   = $entities;
    }

}
