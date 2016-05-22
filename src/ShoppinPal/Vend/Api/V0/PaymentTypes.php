<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\PaymentType;
use YapepBase\Communication\CurlHttpRequest;

class PaymentTypes extends BaseApiAbstract
{
    /**
     * Returns all payment types
     *
     * @return PaymentType[]
     * @throws \Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/payment_types');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        $paymentTypes = [];

        foreach ($result['payment_types'] as $paymentType) {
            $paymentTypes[] = new PaymentType($paymentType, PaymentType::UNKNOWN_PROPERTY_IGNORE);
        }

        return $paymentTypes;
    }

}
