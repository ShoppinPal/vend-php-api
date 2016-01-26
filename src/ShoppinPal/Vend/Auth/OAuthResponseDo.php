<?php

namespace ShoppinPal\Vend\Auth;

use YapepBase\Exception\ParameterException;

/**
 * Data object for storing an OAuth response.
 *
 * All fields are required except for the refresh token.
 */
class OAuthResponseDo
{

    /**
     * The access token.
     *
     * @var string
     */
    public $accessToken;

    /**
     * The token type.
     *
     * @var string
     */
    public $tokenType;

    /**
     * The time the token expires as a Unix timestamp.
     *
     * @var int
     */
    public $expires;

    /**
     * The expiration of the token in seconds relative to when the response was <b>sent</b>.
     *
     * @var int
     */
    public $expiresIn;

    /**
     * The response token if it's present in the response.
     *
     * @var string
     */
    public $refreshToken;

    /**
     * OAuthResponseDo constructor.
     *
     * The data must contain the following required fields:
     * <li>
     *   <ul>access_token</ul>
     *   <ul>token_type</ul>
     *   <ul>expires</ul>
     *   <ul>expires_in</ul>
     * </li>
     *
     * @param array $data The data this DO should represent.
     *
     * @throws ParameterException If the data doesn't contain all required fields.
     */
    public function __construct(array $data)
    {
        $missingKeys = [];

        $requiredKeys = ['access_token', 'token_type', 'expires', 'expires_in'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                $missingKeys[] = $key;
            }
        }

        if (!empty($missingKeys)) {
            throw new ParameterException(
                'The following key(s) are missing from the data array: ' . implode(', ', $missingKeys)
            );
        }

        $this->accessToken = $data['access_token'];
        $this->tokenType   = $data['token_type'];
        $this->expires     = $data['expires'];
        $this->expiresIn   = $data['expires_in'];

        if (isset($data['refresh_token'])) {
            $this->refreshToken = $data['refresh_token'];
        }
    }

}
