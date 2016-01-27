<?php

namespace ShoppinPal\Vend\Auth;

use ShoppinPal\Vend\BaseTest;
use YapepBase\Request\HttpRequest;

class TOAuthCallbackTest extends BaseTest
{

    /**
     * @var TOAuthCallbackMock
     */
    protected $trait;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oauth;

    protected function setUp()
    {
        parent::setUp();
        $this->trait = new TOAuthCallbackMock();

        $this->request = $this->getMockBuilder(HttpRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['getGet'])
            ->getMock();

        $this->trait->request = $this->request;
    }

    public function testError()
    {
        $this->request
            ->method('getGet')
            ->willReturnMap([
                ['code', null, ''],
                ['domain_prefix', null, ''],
                ['state', null, ''],
                ['error', null, 'test']
            ]);

        $this->trait->errorCallback = function($errorMessage) {
            $this->assertEquals('test', $errorMessage);

            return 'ERROR';
        };

        $this->trait->successCallback = function() {
            throw new \PHPUnit_Framework_AssertionFailedError('The success callback should not be called');
        };

        $result = $this->trait->runTest();

        $this->assertEquals('ERROR', $result, 'Invalid return value');
    }

    public function testSuccess()
    {
        $expectedCode         = 'testCode';
        $expectedDomainPrefix = 'testDomainPrefix';
        $expectedState        = 'testState';
        $expectedResponseDo   = new OAuthResponseDo([
            'access_token'  => 'testToken',
            'token_type'    => 'testType',
            'expires'       => time() + 10,
            'expires_in'    => 10,
            'refresh_token' => 'testRefresh',
        ]);

        $this->request
            ->method('getGet')
            ->willReturnMap([
                ['code', null, $expectedCode],
                ['domain_prefix', null, $expectedDomainPrefix],
                ['state', null, $expectedState],
                ['error', null, '']
            ]);

        $this->trait->errorCallback = function($errorMessage) {
            throw new \PHPUnit_Framework_AssertionFailedError('The error callback should not be called');
        };

        $this->trait->successCallback = function(OAuthResponseDo $responseDo, $domainPrefix, $state)
            use ($expectedDomainPrefix, $expectedState, $expectedResponseDo)
        {
            $this->assertEquals($expectedDomainPrefix, $domainPrefix, 'Invalid domain prefix in success callback');
            $this->assertEquals($expectedState, $state, 'Invalid state in success callback');
            $this->assertSame($expectedResponseDo, $responseDo, 'Invalid response DO');

            return 'OK';
        };

        $factory = $this->getFactoryMock();


        $factory->expects($this->once())
            ->method('getOauth')
            ->willReturn($this->getOauthMock($expectedDomainPrefix, $expectedCode, $expectedResponseDo));

        $result = $this->trait->runTest();

        $this->assertEquals('OK', $result, 'Invalid return value');
    }

    protected function getOauthMock($domainPrefix, $code, OAuthResponseDo $responseDo)
    {
        $oauth = $this->getMockBuilder(OAuth::class)
            ->disableOriginalConstructor()
            ->setMethods(['requestAccessToken'])
            ->getMock();

        $oauth->expects($this->once())
            ->method('requestAccessToken')
            ->with($domainPrefix, $code)
            ->willReturn($responseDo);

        return $oauth;
    }

}
