<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSaleTotal extends EntityDoAbstract
{
    public $totalTax;

    public $totalPrice;

    public $totalPayment;

    public $totalToPay;
}
