<?php

namespace ShoppinPal\Vend\Auth;

use ShoppinPal\Vend\BaseTest;
use YapepBase\Communication\CurlHttpRequest;
use YapepBase\Communication\CurlHttpRequestResult;
use YapepBase\DependencyInjection\SystemContainer;

class OAuthTest extends BaseTest
{

    const CLIENT_ID = 'testClientId';
    const CLIENT_SECRET = 'testClientSecret';
    const REDIRECT_URI = 'testRedirectUri';

    /**
     * @var OAuth
     */
    protected $oauth;

    protected function setUp()
    {
        parent::setUp();

        $this->oauth = new OAuth(self::CLIENT_ID, self::CLIENT_SECRET, self::REDIRECT_URI);
    }

    public function testGetAuthorisationRedirectUrl()
    {
        $state = 'testState';

        list($url, $params) = explode('?', $this->oauth->getAuthorisationRedirectUrl($state), 2);

        parse_str($params, $parsedParams);

        $expectedParams = [
            'response_type' => 'code',
            'client_id'     => self::CLIENT_ID,
            'redirect_uri'  => self::REDIRECT_URI,
            'state'         => $state,
        ];

        $this->assertSame('https://secure.vendhq.com/connect', $url, 'Invalid URL part');
        $this->assertEquals($expectedParams, $parsedParams, 'Invalid parameters');
    }

    public function testRequestAccessToken()
    {
        $domainPrefix = 'test';
        $code         = 'testCode';

        $expectedUrl = 'https://test.vendhq.com/api/1.0/token';

        $expectedPayload = [
            'code'          => $code,
            'client_id'     => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => self::REDIRECT_URI,
        ];

        $curlResult = new CurlHttpRequestResult(
            '{
                "access_token": "fMYgxHEYtcyT8cvtvgi1Za5DRs4vArSyvydlnd9f",
                "token_type": "Bearer",
                "expires": 1387145621,
                "expires_in": 86400,
                "refresh_token": "J3F62YPIQdfJjJia1xJuaHp7NoQYtm9y0WadNBTh"
            }',
            [
                'header_size' => 0,
                'http_code' => 200,
            ],
            ''
        );

        $this->setupCurlMock(
            CurlHttpRequest::METHOD_POST,
            $expectedPayload,
            CurlHttpRequest::PAYLOAD_TYPE_FORM_ENCODED,
            $expectedUrl,
            $curlResult
        );

        $result = $this->oauth->requestAccessToken($domainPrefix, $code);

        $this->assertEquals('fMYgxHEYtcyT8cvtvgi1Za5DRs4vArSyvydlnd9f', $result->accessToken, 'Invalid access token');
        $this->assertEquals('Bearer', $result->tokenType, 'Invalid token type');
        $this->assertEquals(1387145621, $result->expires, 'Invalid expiration timestamp');
        $this->assertEquals(86400, $result->expiresIn, 'Invalid expires in value');
        $this->assertEquals('J3F62YPIQdfJjJia1xJuaHp7NoQYtm9y0WadNBTh', $result->refreshToken, 'Invalid refresh token');
    }

    public function testRefreshAccessToken()
    {
        $domainPrefix = 'test';
        $refreshToken = 'J3F62YPIQdfJjJia1xJuaHp7NoQYtm9y0WadNBTh';

        $expectedUrl = 'https://test.vendhq.com/api/1.0/token';

        $expectedPayload = [
            'refresh_token' => $refreshToken,
            'client_id'     => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'grant_type'    => 'refresh_token',
        ];

        $curlResult = new CurlHttpRequestResult(
            '{
                "access_token": "KD7gspXvfAmOsspC65YDqqJQ6FcAYbRROc4zPIMZ",
                "token_type": "Bearer",
                "expires": 1387145621,
                "expires_in": 604800
            }',
            [
                'header_size' => 0,
                'http_code' => 200,
            ],
            ''
        );

        $this->setupCurlMock(
            CurlHttpRequest::METHOD_POST,
            $expectedPayload,
            CurlHttpRequest::PAYLOAD_TYPE_FORM_ENCODED,
            $expectedUrl,
            $curlResult
        );

        $result = $this->oauth->refreshAccessToken($domainPrefix, $refreshToken);

        $this->assertEquals('KD7gspXvfAmOsspC65YDqqJQ6FcAYbRROc4zPIMZ', $result->accessToken, 'Invalid access token');
        $this->assertEquals('Bearer', $result->tokenType, 'Invalid token type');
        $this->assertEquals(1387145621, $result->expires, 'Invalid expiration timestamp');
        $this->assertEquals(604800, $result->expiresIn, 'Invalid expires in value');
        $this->assertNull($result->refreshToken, 'Invalid refresh token');
    }

    public function testAddAuthorisationHeaderToRequest()
    {
        $curlMock = $this->getMockBuilder(CurlHttpRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['addHeader'])
            ->getMock();

        $curlMock->expects($this->once())
            ->method('addHeader')
            ->with('Authorization: Bearer fMYgxHEYtcyT8cvtvgi1Za5DRs4vArSyvydlnd9f');

        $this->oauth->addAuthorisationHeaderToRequest($curlMock, 'Bearer', 'fMYgxHEYtcyT8cvtvgi1Za5DRs4vArSyvydlnd9f');
    }

    protected function setupCurlMock($method, $payload, $payloadType, $url, CurlHttpRequestResult $result)
    {
        $curl = $this->getMockBuilder(CurlHttpRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['setMethod', 'setPayload', 'setUrl', 'send'])
            ->getMock();

        $curl->expects($this->once())
            ->method('setUrl')
            ->with($url);

        $curl->expects($this->once())
            ->method('setMethod')
            ->with($method);

        $curl->expects($this->once())
            ->method('setPayload')
            ->with($payload, $payloadType);

        $curl->expects($this->once())
            ->method('send')
            ->with()
            ->willReturn($result);

        $this->diContainer[SystemContainer::KEY_CURL_HTTP_REQUEST] = $curl;

        return $curl;
    }
}
