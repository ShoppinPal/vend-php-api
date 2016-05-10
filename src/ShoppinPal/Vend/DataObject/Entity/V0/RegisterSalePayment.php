<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSalePayment extends EntityDoAbstract
{
    public $id;

    public $paymentTypeId;

    public $retailerPaymentTypeId;

    public $name;

    public $amount;
}
