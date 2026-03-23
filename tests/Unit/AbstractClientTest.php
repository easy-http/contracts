<?php

namespace EasyHTTP\Contracts\Tests\Unit;

use EasyHTTP\Contracts\Contracts\HTTPClientResponse;
use EasyHTTP\Contracts\Exceptions\HTTPClientException;
use EasyHTTP\Contracts\Exceptions\HTTPConnectionException;
use EasyHTTP\Contracts\Exceptions\ImpossibleToParseJsonException;
use EasyHTTP\Contracts\Tests\Unit\Example\SomeClient;
use PHPUnit\Framework\TestCase;

class AbstractClientTest extends TestCase
{
    protected string $uri = 'http://example.com/api';

    /**
     * @test
     */
    public function itExecutesARequest(): HTTPClientResponse
    {
        $client = new SomeClient();

        $response = $client->call('GET', $this->uri);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('{"key":"value"}', $response->getBody());
        $this->assertSame(
            ['Server' => 'Apache/2.4.38 (Debian)', 'X-Info' => 'GET ' . $this->uri],
            $response->getHeaders()
        );

        return $response;
    }

    /**
     * @test
     * @depends itExecutesARequest
     * @param HTTPClientResponse $response
     * @throws ImpossibleToParseJsonException
     */
    public function itCanParseAResponseToJson(HTTPClientResponse $response)
    {
        $this->assertSame(['key' => 'value'], $response->parseJson());
    }

    /**
     * @test
     */
    public function itPreparesARequestForExecution()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', $this->uri);

        $this->assertSame('GET', $client->getRequest()->getMethod());
        $this->assertSame('http://example.com/api', $client->getRequest()->getUri());
    }

    /**
     * @test
     */
    public function itExecutesAPreparedRequest()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', $this->uri);

        $response = $client->execute();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(['key' => 'value'], $response->parseJson());
        $this->assertSame(
            ['Server' => 'Apache/2.4.38 (Debian)', 'X-Info' => 'GET ' . $this->uri],
            $response->getHeaders()
        );
    }

    /**
     * @test
     */
    public function itReuseTheAdapterForEachRequest()
    {
        $client = new SomeClient();

        $client->call('GET', $this->uri);
        $client->call('GET', $this->uri);
        $client->call('GET', $this->uri);

        $this->assertSame(1, $client->getAdapterCounter());
    }

    /**
     * @test
     */
    public function itSetsHandlers()
    {
        $client = new SomeClient();

        $client->withHandler(
            function () {
                return [
                    'status' => 500,
                    'headers' => ['Server' => 'Apache/2.4.38 (Ubuntu)'],
                    'body' => '{"message":"Server Error"}',
                ];
            }
        );

        $response = $client->call('GET', $this->uri);

        $this->assertSame(500, $response->getStatusCode());
        $this->assertSame(['message' => 'Server Error'], $response->parseJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Ubuntu)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itFlushTheAdapterAfterSetsHandler()
    {
        $client = new SomeClient();

        $liveResponse = $client->call('GET', $this->uri);

        $client->withHandler(
            function () {
                return [
                    'status' => 500,
                    'headers' => ['Server' => 'Apache/2.4 (Ubuntu)'],
                    'body' => 'Server Error - Try later again',
                ];
            }
        );

        $mockedResponse = $client->call('GET', $this->uri);

        $this->assertSame(200, $liveResponse->getStatusCode());
        $this->assertSame(['key' => 'value'], $liveResponse->parseJson());
        $this->assertSame(
            ['Server' => 'Apache/2.4.38 (Debian)', 'X-Info' => 'GET ' . $this->uri],
            $liveResponse->getHeaders()
        );
        $this->assertSame(500, $mockedResponse->getStatusCode());
        $this->assertSame(['Server' => 'Apache/2.4 (Ubuntu)'], $mockedResponse->getHeaders());
    }

    /**
     * This test is just a mock!. The responsibility for throwing this exception lies
     * with the library who is implementing this contracts!
     *
     * @test
     */
    public function itThrowsClientExceptionWhenFails()
    {
        $this->expectException(HTTPClientException::class);

        $client = new SomeClient();

        $client->withHandler(
            function () {
                throw new HTTPClientException('Bad request exception');
            }
        );

        $client->call('GET', $this->uri);
    }

    /**
     * This test is just a mock!. The responsibility for throwing this exception lies
     * with the library who is implementing this contracts!
     *
     * @test
     */
    public function itThrowsClientExceptionWhenConnectionFails()
    {
        $this->expectException(HTTPConnectionException::class);

        $client = new SomeClient();

        $client->withHandler(
            function () {
                throw new HTTPConnectionException('Service is down');
            }
        );

        $client->call('GET', $this->uri);
    }

    public function itThrowsNotParsedExceptionWhenInvalidJsonIsFound()
    {
        $this->expectException(ImpossibleToParseJsonException::class);

        $client = new SomeClient();

        $client->withHandler(
            function () {
                return 'HTTP 500 - Server Error';
            }
        );

        $response = $client->call('GET', $this->uri);
        $response->parseJson();
    }
}
