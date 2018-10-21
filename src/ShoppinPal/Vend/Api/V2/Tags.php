<?php

namespace ShoppinPal\Vend\Api\V2;

use ShoppinPal\Vend\DataObject\Entity\V2\CollectionResult;
use ShoppinPal\Vend\DataObject\Entity\V2\Tag;
use ShoppinPal\Vend\Exception\EntityNotFoundException;
use YapepBase\Communication\CurlHttpRequest;

/**
 * Implements the V2 Tags API
 */
class Tags extends V2ApiAbstract
{

    /**
     * Returns a collection of tags.
     *
     * @param int  $pageSize       The number of items to return per page.
     * @param null $before         The version to succeed the last returned version.
     * @param null $after          The version to precede the first returned version
     * @param bool $includeDeleted If TRUE, deleted items will be returned as well. (required to synchronise deletions)
     *
     * @return CollectionResult
     */
    public function getCollection(
        $pageSize = 50,
        $before = null,
        $after = null,
        $includeDeleted = false
    )
    {
        $params = $this->getCollectionGetterParams($pageSize, $before, $after, $includeDeleted);

        $request = $this->getAuthenticatedRequestForUri('api/2.0/tags', $params);
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'tag get collection');

        $tags = [];

        foreach ($result['data'] as $tag) {
            $tags[] = new Tag($tag, Tag::UNKNOWN_PROPERTY_IGNORE, true);
        }

        return new CollectionResult(
            $result['version']['min'], $result['version']['max'], $tags
        );
    }

    /**
     * Returns the tag, that matches this ID.
     *
     * @param string $tagId ID of the tag.
     *
     * @return Tag
     *
     * @throws EntityNotFoundException If the tag is not found.
     */
    public function get($tagId)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/tags/' . urlencode($tagId));

        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'tag get');

        return new Tag($result['data'], Tag::UNKNOWN_PROPERTY_IGNORE, true);

    }

    /**
     * Creates the specified tag, and returns the Tag instance that represents it.
     *
     * @param Tag $tag The tag to create.
     *
     * @return Tag
     */
    public function create(Tag $tag)
    {
        $request = $this->getAuthenticatedRequestForUri('api/2.0/tags');
        $request->setMethod(CurlHttpRequest::METHOD_POST);

        $request->setPayload(json_encode($tag->toUnderscoredArray()), CurlHttpRequest::PAYLOAD_TYPE_RAW);

        $result = $this->sendRequest($request, 'tag create');

        return new Tag($result['data'], Tag::UNKNOWN_PROPERTY_IGNORE, true);
    }

}
