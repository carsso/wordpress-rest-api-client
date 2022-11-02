<?php

namespace Vnn\WpApiClient\tests;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vnn\WpApiClient\WpClient;
use Vnn\WpApiClient\Endpoint\AbstractWpEndpoint;
use PHPUnit\Framework\TestCase;

/**
 * Test Api class
 *
 * @package  Vnn\WpApiClient\tests
 * @category tests
 */
class AbstractWpEndpointTest extends TestCase
{
    /**
     * Test get() method
     */
    public function testGet()
    {
        $testResponse = new Response(200, ['Content-Type' => 'application/json'], '{"foo": "bar"}');

        $client = $this->createMock(WpClient::class);
        $client->method('send')->with(
            $this->callback(function ($subject) {
                return (string) $subject->getUri() === '/foo/55' && $subject->getMethod() === 'GET';
            })
        )->willReturn($testResponse);

        $endpoint = $this->getMockForAbstractClass(AbstractWpEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/foo');

        $data = $endpoint->get(55);
        $this->assertEquals(
            $data,
            ['foo' => 'bar']
        );
    }

    public function testGetWithoutId()
    {
        $testResponse = new Response(200, ['Content-Type' => 'application/json'], '{"foo": "bar"}');

        $client = $this->createMock(WpClient::class);
        $client->method('send')->with(
            $this->callback(function ($subject) {
                return (string) $subject->getUri() === '/foo' && $subject->getMethod() === 'GET';
            })
        )->willReturn($testResponse);
        $endpoint = $this->getMockForAbstractClass(AbstractWpEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/foo');

        $data = $endpoint->get();
        $this->assertEquals(
            $data,
            ['foo' => 'bar']
        );
    }

    public function testGetWithParameters()
    {
        $testResponse = new Response(200, ['Content-Type' => 'application/json'], '{"foo": "bar"}');

        $client = $this->createMock(WpClient::class);
        $client->method('send')->with(
            $this->callback(function ($subject) {
                return (string) $subject->getUri() === '/foo?bar=baz' && $subject->getMethod() === 'GET';
            })
        )->willReturn($testResponse);

        $endpoint = $this->getMockForAbstractClass(AbstractWpEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/foo');

        $data = $endpoint->get(null, ['bar' => 'baz']);
        $this->assertEquals(
            $data,
            ['foo' => 'bar']
        );
    }

    public function testSave()
    {
        $testResponse = new Response(200, ['Content-Type' => 'application/json'], '{"foo": "bar"}');

        $client = $this->createMock(WpClient::class);

        $client->method('send')->with(
            $this->callback(function ($subject) {
                return (string) $subject->getUri() === '/foo' && $subject->getMethod() === 'POST';
            })
        )->willReturn($testResponse);

        $endpoint = $this->getMockForAbstractClass(AbstractWpEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/foo');

        $data = $endpoint->save(['foo' => 'bar']);
        $this->assertEquals(
            $data,
            ['foo' => 'bar']
        );
    }
}
