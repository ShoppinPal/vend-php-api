<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSalePayment extends EntityDoAbstract
{
    public $id;

    /** @var int {@uses PaymentType::PAYMENT_TYPE_*} */
    public $paymentTypeId;

    public $registerId;

    public $retailerPaymentTypeId;

    public $name;

    public $label;

    public $paymentDate;

    public $amount;
}
