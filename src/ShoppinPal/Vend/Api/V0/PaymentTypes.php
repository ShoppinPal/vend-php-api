<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\PaymentType;
use YapepBase\Communication\CurlHttpRequest;

class PaymentTypes extends V0ApiAbstract
{
    /**
     * Returns all payment types
     *
     * @return PaymentType[]
     * @throws \ShoppinPal\Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/payment_types');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'payment type get all');

        $paymentTypes = [];

        foreach ($result['payment_types'] as $paymentType) {
            $paymentTypes[] = new PaymentType($paymentType, PaymentType::UNKNOWN_PROPERTY_IGNORE);
        }

        return $paymentTypes;
    }

}
