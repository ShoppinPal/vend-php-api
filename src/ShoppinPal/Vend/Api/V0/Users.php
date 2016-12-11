<?php

namespace ShoppinPal\Vend\Api\V0;

use ShoppinPal\Vend\DataObject\Entity\V0\User;
use YapepBase\Communication\CurlHttpRequest;

class Users extends V0ApiAbstract
{
    /**
     * Returns all users
     *
     * @return User[]
     * @throws \ShoppinPal\Vend\Exception\EntityNotFoundException
     * @throws \YapepBase\Exception\CurlException
     * @throws \YapepBase\Exception\Exception
     */
    public function getAll()
    {
        $request = $this->getAuthenticatedRequestForUri('api/users');
        $request->setMethod(CurlHttpRequest::METHOD_GET);

        $result = $this->sendRequest($request, 'user get all');

        $users = [];

        foreach ($result['users'] as $user) {
            $users[] = new User($user, User::UNKNOWN_PROPERTY_IGNORE);
        }

        return $users;
    }
}
