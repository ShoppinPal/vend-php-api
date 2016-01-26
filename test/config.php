<?php

use YapepBase\Config;

Config::getInstance()->clear();
Config::getInstance()->set([
    'resource.vend.oauth.clientId'     => 'testId',
    'resource.vend.oauth.clientSecret' => 'testSecret',
    'resource.vend.oauth.redirectUri'  => 'testUri',
]);
