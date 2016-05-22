<?php

namespace ShoppinPal\Vend;

use YapepBase\Application;

/**
 * Class for helping with the DI container handling.
 */
class DiHelper
{
    /** The key for the factory */
    const KEY_FACTORY = 'vend_factory';

    /** The key for the DI helper */
    const KEY_DI_HELPER = 'vend_diHelper';

    const KEY_DOMAIN_PREFIX = 'vend_domainPrefix';

    /** The key for the OAuth token */
    const KEY_OAUTH_ACCESS_TOKEN = 'vend_oauthAccessToken';

    /** The token type for OAuth */
    const KEY_OAUTH_TOKEN_TYPE = 'vend_oauthTokenType';

    /**
     * Whether the initialisation was completed.
     *
     * @var bool
     */
    protected static $initComplete = false;

    /**
     * DiHelper constructor.
     */
    public function __construct()
    {
        $this->initIfNotDone();
    }

    /**
     * Initialises the Vend library in the DI container.
     *
     * @return void
     */
    public static function init()
    {
        static::getContainer()[self::KEY_FACTORY] = function($container) {
            return new Factory();
        };

        $container = static::getContainer();

        $container[self::KEY_DI_HELPER] = $container->share(function($container) {
            return new static();
        });

        static::$initComplete = true;
    }

    /**
     * Static getter for the DI helper.
     *
     * @return DiHelper
     */
    public static function getInstance()
    {
        static::initIfNotDone();

        return static::getContainer()[self::KEY_DI_HELPER];
    }

    /**
     * Returns a factory instance.
     *
     * @return Factory
     */
    public function getFactory()
    {
        return $this->getContainer()[self::KEY_FACTORY];
    }

    public function getDomainPrefix()
    {
        return $this->getContainer()[self::KEY_DOMAIN_PREFIX];
    }

    public function getOAuthAccessToken()
    {
        return $this->getContainer()[self::KEY_OAUTH_ACCESS_TOKEN];
    }

    public function getOAuthTokenType()
    {
        return $this->getContainer()[self::KEY_OAUTH_TOKEN_TYPE];
    }

    public function setAuthenticationData($domainPrefix, $accessToken, $tokenType = 'Bearer')
    {
        $container = $this->getContainer();

        $container[self::KEY_DOMAIN_PREFIX]      = $domainPrefix;
        $container[self::KEY_OAUTH_ACCESS_TOKEN] = $accessToken;
        $container[self::KEY_OAUTH_TOKEN_TYPE]   = $tokenType;
    }

    /**
     * Initialises the DI helper if it's not already done.
     *
     * @return void
     */
    protected static function initIfNotDone()
    {
        if (!static::$initComplete) {
            static::init();
        }
    }

    /**
     * Returns the current DI container instance.
     *
     * @return \YapepBase\DependencyInjection\SystemContainer
     */
    protected static function getContainer()
    {
        return Application::getInstance()->getDiContainer();
    }
}
