<?php

namespace ShoppinPal\Vend;

use ShoppinPal\Vend\Api\V0\Customers as CustomersV0;
use ShoppinPal\Vend\Api\V0\Products as ProductsV0;
use ShoppinPal\Vend\Auth\AuthHelper;
use ShoppinPal\Vend\Auth\OAuth;
use YapepBase\Config;
use YapepBase\Exception\ParameterException;

/**
 * Factory for the Vend library classes.
 *
 * This class is used to handle the configuration problems for all library classes in this library.
 * The following configuration options are used:
 * <ul>
 *   <li><b>resource.vend.oauth.clientId</b>: The client ID for the application (from the Vend developer center).</li>
 *   <li><b>resource.vend.oauth.clientSecret</b>: The client secret for the application.</li>
 *   <li><b>resource.vend.oauth.redirectUri</b>: The redirect URI for the application. Must match the setting in the Vend developer center.</li>
 *   <li><b>resource.vend.oauth.personalToken</b>: The personal token, if personal token based authentication is used.</li>
 *   <li><b>vend.domainPrefix</b>: The domain prefix for the vend store</li>
 * </ul>
 */
class Factory
{
    /** Version 0 (unversioned, official as of 2016-05-01) API */
    const API_VERSION_0 = 'V0';

    /**
     * @var Config
     */
    protected $config;

    /**
     * Factory constructor.
     */
    public function __construct()
    {
        $this->config = Config::getInstance();
    }

    /**
     * Returns a new OAuth helper instance.
     *
     * @return OAuth
     */
    public function getOAuth()
    {
        $config = Config::getInstance();

        return new OAuth(
            $config->get('resource.vend.oauth.clientId'),
            $config->get('resource.vend.oauth.clientSecret'),
            $config->get('resource.vend.oauth.redirectUri')
        );
    }

    /**
     * Returns an AuthHelper, configured for authentication
     *
     * @return AuthHelper
     *
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getAuthHelper()
    {
        $personalToken = $this->config->get('resource.vend.oauth.personalToken', false);

        if (false !== $personalToken) {
            return new AuthHelper('Bearer', $personalToken);
        }

        // TODO implement for OAuth
    }

    /**
     * Returns a Customers API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return CustomersV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getCustomersApi($version)
    {
        $domainPrefix = $this->config->get('vend.domainPrefix');

        switch ($version) {
            case 'V0':
                return new CustomersV0($this->getAuthHelper(), $domainPrefix);
            
            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Products API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return ProductsV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getProductsApi($version)
    {
        $domainPrefix = $this->config->get('vend.domainPrefix');

        switch ($version) {
            case 'V0':
                return new ProductsV0($this->getAuthHelper(), $domainPrefix);

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }
}
