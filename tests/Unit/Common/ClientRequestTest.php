<?php

namespace EasyHttp\Contracts\Tests\Unit\Common;

use EasyHttp\Contracts\Common\SecurityContext;
use EasyHttp\Contracts\Tests\TestCase;
use EasyHttp\Contracts\Tests\Unit\Example\ClientRequest;

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
        $this->assertEmpty($request->getBody());
        $this->assertFalse($request->hasJson());
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
        $request->setJson(['foo' => 'bar']);
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
        $this->assertSame(['foo' => 'bar'], $request->getJson());
        $this->assertTrue($request->hasJson());
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
    public function itCanSetTheBodyAsJson()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $request->setJson(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $request->getJson());
        $this->assertSame('{"foo":"bar"}', $request->getBody());
    }

    /**
     * @test
     */
    public function itCannotParseWrontJsonValues()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $request->setJson(["\xc3" => 'bar']);

        $this->assertSame('', $request->getBody());
    }

    /**
     * @test
     */
    public function itCanChangeTheBodyPreviouslyAsJson()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $request->setJson(['foo' => 'bar']);
        $request->setBody('Not Found');

        $this->assertSame([], $request->getJson());
        $this->assertSame('Not Found', $request->getBody());
    }

    /**
     * @test
     */
    public function itCanChangeTheBodyPreviouslyAsPlainText()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $request->setBody('Not Found');
        $request->setJson(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $request->getJson());
        $this->assertSame('{"foo":"bar"}', $request->getBody());
    }

    /**
     * @test
     */
    public function itHasBodyForJsonAssignment()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $this->assertFalse($request->hasBody());

        $request->setJson(['foo' => 'bar']);

        $this->assertTrue($request->hasBody());
    }

    /**
     * @test
     */
    public function itHasBodyWhenItIsAssigned()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $this->assertFalse($request->hasBody());

        $request->setBody('Not Found');

        $this->assertTrue($request->hasBody());
    }
}
