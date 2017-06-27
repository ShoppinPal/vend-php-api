<?php

namespace ShoppinPal\Vend\DataObject\Entity\V2;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Register extends EntityDoAbstract
{
    const DISPLAY_PRICES_INCLUSIVE = 'inclusive';
    const DISPLAY_PRICES_EXCLUSIVE = 'exclusive';

    public $id;

    public $name;

    public $outletId;

    public $askForNoteOnSale;

    public $showDiscountsOnReceipts;

    public $printReceipt;

    public $emailReceipt;

    public $invoicePrefix;

    public $invoiceSuffix;

    public $invoiceSequence;

    public $buttonLayoutId;

    public $registerOpenTime;

    public $registerCloseTime;

    public $registerOpenSequenceId;

    public $deletedAt;

    public $attributes = [];

    public $version;

    public $isOpen;

    public $isQuickKeysEnabled;

    public $cashManagedPaymentTypeId;
}
