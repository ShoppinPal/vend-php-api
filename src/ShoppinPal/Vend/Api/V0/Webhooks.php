<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\Webhook;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Exception\Exception;

class Webhooks extends V0ApiAbstract
{
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'webhook get all');

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

        $result = $this->sendRequest($request, 'webhook get');

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

        $result = $this->sendRequest($request, 'webhook create');

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

        $result = $this->sendRequest($request, 'webhook update');

        return new Webhook($result, Webhook::UNKNOWN_PROPERTY_IGNORE);
    }

    public function delete($webhookId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/webhooks/' . urlencode($webhookId));;
        $request->setMethod(CurlHttpRequest::METHOD_DELETE);

        $result = $this->sendRequest($request, 'webhook delete');

        if (empty($result['status']) || 'success' != $result['status']) {
            throw new Exception('Invalid response received for webhook delete request.', 0, null, $result);
        }
    }
}
