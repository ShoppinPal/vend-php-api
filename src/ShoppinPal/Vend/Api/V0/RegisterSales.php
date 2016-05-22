<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\RegisterSale;
use YapepBase\Communication\CurlHttpRequest;

class RegisterSales extends BaseApiAbstract
{
    public function create(RegisterSale $registerSale)
    {
        $request = $this->getAuthenticatedRequestForUri('api/register_sales');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($registerSale->toUnderscoredArray([], true)), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request);

        return new RegisterSale($result['register_sale'], RegisterSale::UNKNOWN_PROPERTY_IGNORE);

    }
}
