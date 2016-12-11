<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Register extends EntityDoAbstract
{

    protected $subEntities = [
        'quickKeysTemplate' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterQuickKeysTemplate::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        ],
        'receipt' => [
            self::SUB_ENTITY_KEY_CLASS => RegisterReceipt::class,
            self::SUB_ENTITY_KEY_TYPE  => self::SUB_ENTITY_TYPE_SINGLE,
        ],
    ];

    public $id;

    public $name;

    public $outletId;

    public $buttonLayoutId;

    public $printReceipt;

    public $emailReceipt;

    public $askForNoteOnSave;

    public $printNoteOnReceipt;

    public $askForUserOnSale;

    public $showDiscountsOnReceipt;

    public $receiptHeader;

    public $receiptBarcoded;

    public $receiptFooter;

    public $receiptStyleClass;

    public $invoicePrefix;

    public $invoiceSuffix;

    public $invoiceSequence;

    public $registerOpenCountSequence;

    public $registerOpenSequenceId;

    public $registerOpenTime;

    public $registerCloseTime;

    public $cashManagementTypeId;

    public $isQuickKeysEnabled;

    public $quickKeyTemplateId;

    /** @var RegisterQuickKeysTemplate */
    public $quickKeysTemplate;

    /** @var RegisterReceipt */
    public $receipt;
}
