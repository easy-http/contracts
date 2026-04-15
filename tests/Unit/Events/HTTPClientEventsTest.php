<?php

namespace EasyHTTP\Contracts\Tests\Unit\Events;

use EasyHTTP\Contracts\Constants\HTTPClientEvent;
use EasyHTTP\Contracts\Events\RequestFailed;
use EasyHTTP\Contracts\Events\RequestStarted;
use EasyHTTP\Contracts\Events\RequestSucceeded;
use EasyHTTP\Contracts\Events\StreamSucceeded;
use EasyHTTP\Contracts\Tests\TestCase;
use EasyHTTP\Contracts\Tests\Unit\Example\ClientRequest;
use EasyHTTP\Contracts\Tests\Unit\Example\ClientResponse;
use EasyHTTP\Contracts\Tests\Unit\Example\StreamResponse;
use RuntimeException;

class HTTPClientEventsTest extends TestCase
{
    /**
     * @test
     */
    public function itBuildsARequestStartedEvent()
    {
        $request = new ClientRequest('POST', 'https://api.example.com/users');

        $event = new RequestStarted(
            $request,
            ['feature' => 'logging']
        );

        $this->assertSame(HTTPClientEvent::REQUEST_STARTED, $event->getName());
        $this->assertSame($request, $event->getRequest());
        $this->assertSame(['feature' => 'logging'], $event->getContext());
    }

    /**
     * @test
     */
    public function itBuildsARequestSucceededEvent()
    {
        $response = new ClientResponse([
            'status' => 200,
            'headers' => ['Server' => 'Apache'],
            'body' => '{"ok":true}'
        ]);

        $event = new RequestSucceeded(
            $response
        );

        $this->assertSame(HTTPClientEvent::REQUEST_SUCCEEDED, $event->getName());
        $this->assertSame($response, $event->getResponse());
    }

    /**
     * @test
     */
    public function itBuildsARequestFailedEvent()
    {
        $exception = new RuntimeException('Network timeout');
        $request = new ClientRequest('PATCH', 'https://api.example.com/users/10');

        $event = new RequestFailed(
            $request,
            $exception
        );

        $this->assertSame(HTTPClientEvent::REQUEST_FAILED, $event->getName());
        $this->assertSame($request, $event->getRequest());
        $this->assertSame($exception, $event->getException());
    }

    /**
     * @test
     */
    public function itBuildsAStreamSucceededEvent()
    {
        $response = new StreamResponse([
            'status' => 200,
            'headers' => ['Server' => 'Apache'],
            'body' => 'chunk one'
        ]);

        $event = new StreamSucceeded(
            $response
        );

        $this->assertSame(HTTPClientEvent::STREAM_SUCCEEDED, $event->getName());
        $this->assertSame($response, $event->getResponse());
    }
}
