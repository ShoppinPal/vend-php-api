<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\Api\BaseApiAbstract;
use ShoppinPal\Vend\DataObject\Entity\V0\Webhook;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Exception\Exception;

class Webhooks extends BaseApiAbstract
{
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        $webhooks = [];

        foreach ($result as $webhook) {
            $webhooks[] = new Webhook($webhook, Webhook::UNKNOWN_PROPERTY_IGNORE);
        }

        return $webhooks;
    }

    public function get($webhookId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks/' . urlencode($webhookId));
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request);

        return new Webhook($result, Webhook::UNKNOWN_PROPERTY_IGNORE);

    }

    public function create(Webhook $webhook)
    {
        $modifiedWebhook = clone($webhook);
        $modifiedWebhook->id = null;

        $request = $this->getAuthenticatedRequestForUri('api/webhooks', [], true);
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(
            ['data' => json_encode($modifiedWebhook->toUnderscoredArray([], true))],
            CurlHttpRequest::PAYLOAD_TYPE_FORM_ENCODED
        );

        $result = $this->sendRequest($request);

        return new Webhook($result, Webhook::UNKNOWN_PROPERTY_IGNORE);
    }

    public function update($webhookId, Webhook $webhook)
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks/' . urlencode($webhookId), [], true);
        $request->setMethod(CurlHttpRequest::METHOD_PUT);

        $request->setPayload(
            ['data' => json_encode($webhook->toUnderscoredArray([], true))],
            CurlHttpRequest::PAYLOAD_TYPE_FORM_ENCODED
        );

        $result = $this->sendRequest($request);

        return new Webhook($result, Webhook::UNKNOWN_PROPERTY_IGNORE);
    }

    public function delete($webhookId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks/' . urlencode($webhookId));;
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $result = $this->sendRequest($request);

        if (empty($result['status']) || 'success' != $result['status']) {
            throw new Exception('Invalid response received for webhook delete request.', 0, null, $result);
        }
    }
}
