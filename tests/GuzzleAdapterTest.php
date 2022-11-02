<?php

namespace Vnn\WpApiClient\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\UriInterface;
use Vnn\WpApiClient\Http\GuzzleAdapter;
use Vnn\WpApiClient\Http\ClientInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test Api class
 *
 * @package  Vnn\WpApiClient\tests
 * @category tests
 */
class GuzzleAdapterTest extends TestCase
{
    /**
     * @var ClientInterface
     */
    private $adapter;

    /**
     * Define id to create object
     */
    protected function setUp() :void
    {
        $this->adapter = new GuzzleAdapter();
    }

    /**
     * Test makeUri() method returning a Guzzle Uri object wrapping the string
     */
    public function testMakeUri()
    {
        $uri = $this->adapter->makeUri('http://example.com');
        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertEquals($uri->getScheme(), 'http');
        $this->assertEquals($uri->getHost(), 'example.com');
    }

    /**
     * Test send() method passing the request off to Guzzle and return the response
     */
    public function testSend()
    {
        $client = $this->createMock(Client::class);
        $adapter = new GuzzleAdapter($client);

        $request = new Request('GET', 'http://example.com');
        $expectedResponse = new Response();

        $client->method('send')->willReturn($expectedResponse);

        $response = $adapter->send($request);

        $this->assertInstanceOf(Response::class, $response);
    }
}
