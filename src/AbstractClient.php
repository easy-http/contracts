<?php

namespace EasyHTTP\Contracts;

use EasyHTTP\Contracts\Contracts\HTTPClientContract;
use EasyHTTP\Contracts\Contracts\HTTPClientAdapter;
use EasyHTTP\Contracts\Contracts\HTTPClientEvent;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use EasyHTTP\Contracts\Contracts\HTTPClientResponse;
use EasyHTTP\Contracts\Contracts\HTTPStreamResponse;
use EasyHTTP\Contracts\Events\RequestFailed;
use EasyHTTP\Contracts\Events\RequestStarted;
use EasyHTTP\Contracts\Events\RequestSucceeded;
use Psr\EventDispatcher\EventDispatcherInterface;
use Throwable;

abstract class AbstractClient implements HTTPClientContract
{
    protected HTTPClientAdapter $adapter;
    protected HTTPClientRequest $request;
    protected HTTPClientFactory $factory;
    protected $handler;
    protected ?EventDispatcherInterface $eventDispatcher = null;

    public function __construct(HTTPClientFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getRequest(): HTTPClientRequest
    {
        return $this->request;
    }

    public function call(string $method, string $uri): HTTPClientResponse
    {
        $request = $this->factory->createRequest($method, $uri);

        $this->emit(new RequestStarted($request, ['operation' => 'call']));

        try {
            $response = $this->getAdapter()->request($request);
            $this->emit(new RequestSucceeded($response, ['operation' => 'call']));

            return $response;
        } catch (Throwable $exception) {
            $this->emit(new RequestFailed($request, $exception, ['operation' => 'call']));
            throw $exception;
        }
    }

    public function prepareRequest(string $method, string $uri): HTTPClientRequest
    {
        $this->request = $this->factory->createRequest($method, $uri);

        return $this->request;
    }

    public function withHandler(callable $handler): self
    {
        $this->flushAdapter();
        $this->handler = $handler;

        return $this;
    }

    public function withEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    public function execute(): HTTPClientResponse
    {
        $this->emit(new RequestStarted($this->request, ['operation' => 'execute']));

        try {
            $response = $this->getAdapter()->request($this->request);
            $this->emit(new RequestSucceeded($response, ['operation' => 'execute']));

            return $response;
        } catch (Throwable $exception) {
            $this->emit(new RequestFailed($this->request, $exception, ['operation' => 'execute']));
            throw $exception;
        }
    }

    public function stream(): HTTPStreamResponse
    {
        $this->emit(new RequestStarted($this->request, ['operation' => 'stream']));

        try {
            $response = $this->getAdapter()->stream($this->request);

            return $response;
        } catch (Throwable $exception) {
            $this->emit(new RequestFailed($this->request, $exception, ['operation' => 'stream']));
            throw $exception;
        }
    }

    protected function emit(HTTPClientEvent $event): void
    {
        if (!$this->hasEventDispatcher()) {
            return;
        }

        $this->eventDispatcher->dispatch($event);
    }

    protected function hasEventDispatcher(): bool
    {
        return $this->eventDispatcher !== null;
    }

    protected function getAdapter(): HTTPClientAdapter
    {
        if ($this->hasAdapter()) {
            return $this->adapter;
        }

        $this->adapter = $this->factory->createAdapter($this->handler);

        return $this->adapter;
    }

    protected function hasAdapter(): bool
    {
        return (bool) ($this->adapter ?? null);
    }

    protected function hasHandler(): bool
    {
        return (bool) ($this->handler ?? null);
    }

    protected function flushAdapter(): void
    {
        unset($this->adapter);
    }
}
