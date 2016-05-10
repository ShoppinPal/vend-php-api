<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class CollectionResult
{

    /**
     * @var int
     */
    public $resultCount;

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $pageSize;

    /**
     * @var int
     */
    public $totalPages;

    /**
     * @var EntityDoAbstract[]
     */
    public $entities;

    /**
     * CollectionResult constructor.
     *
     * @param int                $resultCount
     * @param int                $page
     * @param int                $pageSize
     * @param int                $totalPages
     * @param EntityDoAbstract[] $entities
     */
    public function __construct($resultCount, $page, $pageSize, $totalPages, array $entities)
    {
        $this->resultCount = $resultCount;
        $this->page        = $page;
        $this->pageSize    = $pageSize;
        $this->totalPages  = $totalPages;
        $this->entities    = $entities;
    }

}
