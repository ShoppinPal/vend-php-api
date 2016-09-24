<?php

namespace ShoppinPal\Vend\DataObject\Entity\V1;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class RegisterSaleTotal extends EntityDoAbstract
{
    public $totalPrice;

    public $totalTax;

    public $totalPayment;

    public $totalToPay;
}
