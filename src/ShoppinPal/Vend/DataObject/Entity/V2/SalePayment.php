<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class SalePayment extends EntityDoAbstract
{

    public $id;

    public $registerId;

    public $outletId;

    public $retailerPaymentTypeId;

    /** @var int {@uses PaymentType::PAYMENT_TYPE_*} */
    public $paymentTypeId;

    public $name;

    public $amount;

    public $paymentDate;

    public $deletedAt;

    // TODO readd this later
    // public $externalAttributes = [];

    public $sourceId;
}
