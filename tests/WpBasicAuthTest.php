<?php

namespace Vnn\WpApiClient\tests;

use GuzzleHttp\Psr7\Request;
use Vnn\WpApiClient\Auth\WpBasicAuth;
use PHPUnit\Framework\TestCase;

/**
 * Test Api class
 *
 * @package  Vnn\WpApiClient\tests
 * @category tests
 */
class WpBasicAuthTest extends TestCase
{
    /**
     * Test addCredentials() method returning a request with the proper Authorization header
     */
    public function testAddCredentials()
    {
        $auth = new WpBasicAuth('jim', 'hunter2');
        $request = new Request('GET', '/users');

        $newRequest = $auth->addCredentials($request);

        $this->assertInstanceOf(Request::class, $newRequest);
        $this->assertEquals(
            $newRequest->getHeader('Authorization'),
            ['Basic ' . base64_encode('jim:hunter2')]
        );
    }
}
