<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSalePayment extends EntityDoAbstract
{
    public $id;

    public $paymentDate;

    public $amount;

    public $retailerPaymentTypeId;

    public $paymentTypeId;
}
