<?php

namespace EasyHTTP\Contracts\Tests\Unit\Common\Request;

use EasyHTTP\Contracts\Common\Request\IterableBodyPayload;
use EasyHTTP\Contracts\Common\Request\JsonBodyPayload;
use EasyHTTP\Contracts\Common\Request\ResourceBodyPayload;
use EasyHTTP\Contracts\Common\Request\StringBodyPayload;
use EasyHTTP\Contracts\Common\Request\UrlEncodedBodyPayload;
use EasyHTTP\Contracts\Tests\TestCase;
use EasyHTTP\Contracts\Tests\Unit\Example\ClientRequest;
use ArrayIterator;
use Generator;

class BodyPayloadTest extends TestCase
{
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
    public function itCanAssignAnArrayBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new IterableBodyPayload(['chunk-one', 'chunk-two']);

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(
            ['chunk-one', 'chunk-two'],
            $request->getBodyPayload()->getContents()
        );
    }

    /**
     * @test
     */
    public function itCanAssignATraversableBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);
        $payload = new IterableBodyPayload(new ArrayIterator(['chunk-one', 'chunk-two']));

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
    public function itCanAssignAGeneratorBodyPayload()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $generator = function (string $data): Generator {
            // breakdown the body by spaces into chunks
            $chunks = explode(' ', $data);
            foreach ($chunks as $chunk) {
                yield $chunk;
            }
        };

        $generatorExample = function () use ($generator) {
            return $generator('key value');
        };

        $payload = new IterableBodyPayload($generatorExample());

        $request->setBodyPayload($payload);

        $this->assertSame($payload, $request->getBodyPayload());
        $this->assertSame(
            ['key', 'value'],
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
