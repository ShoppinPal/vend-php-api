<?php

namespace ShoppinPal\Vend\DataObject\Entity\V0;

use ShoppinPal\Vend\DataObject\Entity\EntityDoAbstract;

class Webhook extends EntityDoAbstract
{
    const TYPE_PRODUCT_UPDATE = 'product.update';

    const TYPE_INVENTORY_UPDATE = 'inventory.update';

    const TYPE_CONSIGNMENT_SENT = 'consignment.sent';

    const TYPE_CONSIGNMENT_RECEIVE = 'consignment.receive';

    const TYPE_CUSTOMER_UPDATE = 'customer.update';

    const TYPE_SALE_UPDATE = 'sale.update';

    public $id;

    public $active;

    public $retailerId;

    public $type;

    public $url;
}
