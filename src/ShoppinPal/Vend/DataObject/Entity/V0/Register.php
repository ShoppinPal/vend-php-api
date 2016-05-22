<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Register extends EntityDoAbstract
{

    public $id;

    public $name;

    public $outletId;

    public $printReceipt;

    public $receiptHeader;

    public $receiptFooter;

    public $receiptStyleSheet;

    public $invoicePrefix;

    public $invoiceSuffix;

    public $invoiceSequence;

    public $registerOpenCountSequence;

    public $registerOpenTime;

    public $registerCloseTime;
}
