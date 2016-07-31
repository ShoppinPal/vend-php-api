<?php

namespace ShoppinPal\Vend;

use ShoppinPal\Vend\Api\V0\Customers as CustomersV0;
use ShoppinPal\Vend\Api\V0\Outlets as OutletsV0;
use ShoppinPal\Vend\Api\V0\Products as ProductsV0;
use ShoppinPal\Vend\Api\V0\PaymentTypes as PaymentTypesV0;
use ShoppinPal\Vend\Api\V0\Registers as RegistersV0;
use ShoppinPal\Vend\Api\V0\RegisterSales as RegisterSalesV0;
use ShoppinPal\Vend\Api\V0\Webhooks as WebhooksV0;
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
        $diHelper = DiHelper::getInstance();
        return new AuthHelper($diHelper->getOAuthTokenType(), $diHelper->getOAuthAccessToken());
    }

    /**
     * Returns the current domain prefix
     *
     * @return string
     */
    protected function getDomainPrefix()
    {
        return DiHelper::getInstance()->getDomainPrefix();
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
        switch ($version) {
            case 'V0':
                return new CustomersV0($this->getAuthHelper(), $this->getDomainPrefix());
            
            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns an Outlets API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return OutletsV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getOutletsApi($version)
    {
        switch ($version) {
            case 'V0':
                return new OutletsV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Payment Types API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return PaymentTypesV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getPaymentTypesApi($version)
    {
        switch ($version) {
            case 'V0':
                return new PaymentTypesV0($this->getAuthHelper(), $this->getDomainPrefix());

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
        switch ($version) {
            case 'V0':
                return new ProductsV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Registers API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return RegistersV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getRegistersApi($version)
    {
        switch ($version) {
            case 'V0':
                return new RegistersV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Register Sales API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return RegisterSalesV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getRegisterSalesApi($version)
    {
        switch ($version) {
            case 'V0':
                return new RegisterSalesV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Webhooks API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return WebhooksV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getWebhooksApi($version)
    {
        switch ($version) {
            case 'V0':
                return new WebhooksV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }
}
