<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class PaymentType extends EntityDoAbstract
{
    const PAYMENT_TYPE_CASH = 1;

    const PAYMENT_TYPE_CHEQUE = 2;

    const PAYMENT_TYPE_CREDIT_CARD = 3;

    const PAYMENT_TYPE_EFTPOS = 4;

    public $id;

    public $name;

    public $paymentTypeId;
}
