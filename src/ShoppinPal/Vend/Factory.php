<?php

namespace ShoppinPal\Vend;

use ShoppinPal\Vend\Api\V0\Customers as CustomersV0;
use ShoppinPal\Vend\Api\V0\Outlets as OutletsV0;
use ShoppinPal\Vend\Api\V0\Products as ProductsV0;
use ShoppinPal\Vend\Api\V0\PaymentTypes as PaymentTypesV0;
use ShoppinPal\Vend\Api\V0\Registers as RegistersV0;
use ShoppinPal\Vend\Api\V0\RegisterSales as SalesV0;
use ShoppinPal\Vend\Api\V0\Suppliers as SuppliersV0;
use ShoppinPal\Vend\Api\V0\Taxes as TaxesV0;
use ShoppinPal\Vend\Api\V0\Users as UsersV0;
use ShoppinPal\Vend\Api\V0\Webhooks as WebhooksV0;
use ShoppinPal\Vend\Api\V2\Customers as CustomersV2;
use ShoppinPal\Vend\Api\V2\Inventory as InventoryV2;
use ShoppinPal\Vend\Api\V2\Outlets as OutletsV2;
use ShoppinPal\Vend\Api\V2\PaymentTypes as PaymentTypesV2;
use ShoppinPal\Vend\Api\V2\PriceBooks as PriceBooksV2;
use ShoppinPal\Vend\Api\V2\Products as ProductsV2;
use ShoppinPal\Vend\Api\V2\Registers as RegistersV2;
use ShoppinPal\Vend\Api\V2\Sales as SalesV2;
use ShoppinPal\Vend\Api\V2\Versions as VersionsV2;
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

    /** Version 2 (BETA as of 2016-10-02) API  */
    const API_VERSION_2 = 'V2';

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
     * @return CustomersV0|CustomersV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getCustomersApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new CustomersV0($this->getAuthHelper(), $this->getDomainPrefix());
            
            case self::API_VERSION_2:
                return new CustomersV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns an Inventory API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return InventoryV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getInventoryApi($version)
    {
        switch ($version) {
            case self::API_VERSION_2:
                return new InventoryV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns an Outlets API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return OutletsV0|OutletsV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getOutletsApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new OutletsV0($this->getAuthHelper(), $this->getDomainPrefix());

            case self::API_VERSION_2:
                return new OutletsV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Payment Types API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return PaymentTypesV0|PaymentTypesV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getPaymentTypesApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new PaymentTypesV0($this->getAuthHelper(), $this->getDomainPrefix());

            case self::API_VERSION_2:
                return new PaymentTypesV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Price Books API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return PriceBooksV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getPriceBooksApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                throw new ParameterException('The V0 API version has no pricebooks API');
                break;

            case self::API_VERSION_2:
                return new PriceBooksV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Products API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return ProductsV0|ProductsV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getProductsApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new ProductsV0($this->getAuthHelper(), $this->getDomainPrefix());

            case self::API_VERSION_2:
                return new ProductsV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Registers API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return RegistersV0|RegistersV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getRegistersApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new RegistersV0($this->getAuthHelper(), $this->getDomainPrefix());

            case self::API_VERSION_2:
                return new RegistersV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Register Sales API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return SalesV0|SalesV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     *
     * @deprecated Will be removed in next minor or major release. Use getSalesApi instead
     */
    public function getRegisterSalesApi($version)
    {
        return $this->getSalesApi($version);
    }

    /**
     * Returns a Sales API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return SalesV0|SalesV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getSalesApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new SalesV0($this->getAuthHelper(), $this->getDomainPrefix());

            case self::API_VERSION_2:
                return new SalesV2($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Suppliers API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return SuppliersV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getSuppliersApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new SuppliersV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Taxes API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return TaxesV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getTaxesApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new TaxesV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Users API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return UsersV0
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getUsersApi($version)
    {
        switch ($version) {
            case self::API_VERSION_0:
                return new UsersV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }

    /**
     * Returns a Versions API handler.
     *
     * @param string $version The version to use. {@uses self::API_VERSION_*}
     *
     * @return VersionsV2
     *
     * @throws ParameterException If the version is invalid.
     * @throws \YapepBase\Exception\ConfigException If the required configuration params are not set.
     */
    public function getVersionsApi($version)
    {
        switch ($version) {
            case self::API_VERSION_2:
                return new VersionsV2($this->getAuthHelper(), $this->getDomainPrefix());

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
            case self::API_VERSION_0:
                return new WebhooksV0($this->getAuthHelper(), $this->getDomainPrefix());

            default:
                throw new ParameterException('Unknown version: ' . $version);
        }
    }
}
