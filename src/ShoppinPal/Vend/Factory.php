<?php

namespace ShoppinPal\Vend;

use ShoppinPal\Vend\Auth\OAuth;
use YapepBase\Config;

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
}
