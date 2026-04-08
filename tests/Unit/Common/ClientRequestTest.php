<?php

namespace EasyHTTP\Contracts\Tests\Unit\Common;

use EasyHTTP\Contracts\Common\Request\IterableBodyPayload;
use EasyHTTP\Contracts\Common\Request\JsonBodyPayload;
use EasyHTTP\Contracts\Common\Request\ResourceBodyPayload;
use EasyHTTP\Contracts\Common\Request\StringBodyPayload;
use EasyHTTP\Contracts\Common\Request\UrlEncodedBodyPayload;
use EasyHTTP\Contracts\Common\SecurityContext;
use EasyHTTP\Contracts\Tests\TestCase;
use EasyHTTP\Contracts\Tests\Unit\Example\ClientRequest;

class ClientRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itSetsInitialProperties()
    {
        $method = 'POST';
        $url = $this->faker->url;

        $request = new ClientRequest($method, $url);

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($url, $request->getUri());
        $this->assertFalse($request->hasHeaders());
        $this->assertNull($request->getBodyPayload());
        $this->assertFalse($request->hasQuery());
        $this->assertFalse($request->hasSecurityContext());
        $this->assertFalse($request->isSSL());
        $this->assertFalse($request->hasBasicAuth());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $method = 'GET';
        $url = $this->faker->url;
        $request->setMethod($method);
        $request->setUri($url);
        $payload = new JsonBodyPayload(['foo' => 'bar']);
        $request->setBodyPayload($payload);
        $request->setQuery(['bar' => 'baz']);
        $request->setTimeout(20);
        $request->setHeaders(['a' => 'b']);
        $request->setHeader('auth', 'xdsG56');
        $request->setBasicAuth('user', 'pass');
        $security = new SecurityContext();
        $request->setSecurityContext($security);
        $request->ssl(true);

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($url, $request->getUri());
        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(['bar' => 'baz'], $request->getQuery());
        $this->assertTrue($request->hasQuery());
        $this->assertSame(20, $request->getTimeout());
        $this->assertSame('xdsG56', $request->getHeader('auth'));
        $this->assertSame(['a' => 'b', 'auth' => 'xdsG56'], $request->getHeaders());
        $this->assertTrue($request->hasHeaders());
        $this->assertSame(['user', 'pass'], $request->getBasicAuth());
        $this->assertTrue($request->hasBasicAuth());
        $this->assertTrue($request->hasSecurityContext());
        $this->assertTrue($request->isSSL());
    }

    /**
     * @test
     */
    public function itCanAssignAStringBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new StringBodyPayload('Some payload');

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame('Some payload', $request->getBodyPayload()->getContents());
    }

    /**
     * @test
     */
    public function itCanAssignAJsonBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new JsonBodyPayload(['foo' => 'bar']);

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(['foo' => 'bar'], $request->getBodyPayload()->getContents());
    }

    /**
     * @test
     */
    public function itCanAssignAUrlEncodedBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new UrlEncodedBodyPayload(['foo' => 'bar', 'flag' => 'enabled']);

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(['foo' => 'bar', 'flag' => 'enabled'], $request->getBodyPayload()->getContents());
    }

    /**
     * @test
     */
    public function itCanAssignAnIterableBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new IterableBodyPayload(['chunk-one', 'chunk-two']);

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(
            ['chunk-one', 'chunk-two'],
            iterator_to_array($request->getBodyPayload()->getContents(), false)
        );
    }

    /**
     * @test
     */
    public function itCanAssignAResourceBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $resource = fopen('php://memory', 'r+');
        $this->assertIsResource($resource);
        fwrite($resource, 'sample');
        rewind($resource);
        $payload = new ResourceBodyPayload($resource);

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertIsResource($request->getBodyPayload()->getContents());

        fclose($resource);
    }

    /**
     * @test
     */
    public function itReplacesBodyPayloadWhenSettingAnotherOne()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $request->setBodyPayload(new StringBodyPayload('first'));

        $payload = new JsonBodyPayload(['next' => 'value']);
        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(['next' => 'value'], $request->getBodyPayload()->getContents());
    }
}
