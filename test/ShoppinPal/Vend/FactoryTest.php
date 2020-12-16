<?php

namespace ShoppinPal\Vend;

use ShoppinPal\Vend\Auth\OAuth;
use YapepBase\Config;

/**
 * Class FactoryTest
 *
 * @covers ShoppinPal\Vend\Factory
 */
class FactoryTest extends BaseTest
{

    protected function setUp(): void
    {
        parent::setUp();

        Config::getInstance()->set(
            [
                'resource.vend.oauth.clientId'     => 'clientId',
                'resource.vend.oauth.clientSecret' => 'clientSecret',
                'resource.vend.oauth.redirectUri'  => 'redirectUri',
            ]
        );
    }

    public function testGetOAuth()
    {
        $factory = new Factory();

        $result = $factory->getOAuth();

        $this->assertInstanceOf(OAuth::class, $result, 'Invalid return value for getOauth()');

        $reflection = new \ReflectionClass($result);

        $expectedValues = [
            'clientId'     => 'clientId',
            'clientSecret' => 'clientSecret',
            'redirectUri'  => 'redirectUri',
        ];

        foreach ($expectedValues as $name => $value) {
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $this->assertEquals($value, $property->getValue($result), 'Invalid value used for ' . $name);
        }
    }
}
