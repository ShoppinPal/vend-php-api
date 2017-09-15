<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\Tax;
use ShoppinPal\Vend\DataObject\Entity\V0\TaxRequest;
use YapepBase\Communication\CurlHttpRequest;

class Taxes extends V0ApiAbstract
{
    /**
     * Returns all taxes
     *
     * @return Tax[]
     * @throws \ShoppinPal\Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/taxes');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'tax get all');

        $taxes = [];

        foreach ($result['taxes'] as $tax) {
            $taxes[] = new Tax($tax, Tax::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return $taxes;
    }

    /**
     * Creates a tax
     *
     * @param TaxRequest $taxRequest
     *
     * @return Tax
     */
    public function create(TaxRequest $taxRequest)
    {
        $request = $this->getAuthenticatedRequestForUri('api/taxes');
        $request->setMethod(CurlHttpRequest::METHOD_POST);
        $request->setPayload($taxRequest->toUnderscoredArray([], true), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'tax create');

        return new Tax($result['tax'], Tax::UNKNOWN_PROPERTY_IGNORE, true);
    }
}
