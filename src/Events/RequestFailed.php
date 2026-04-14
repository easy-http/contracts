<?php

namespace EasyHTTP\Contracts\Events;

use EasyHTTP\Contracts\Contracts\HTTPClientRequest;
use Throwable;

class RequestFailed extends AbstractHTTPClientEvent
{
    protected HTTPClientRequest $request;
    protected Throwable $exception;

    /**
     * @param array $context
     */
    public function __construct(
        HTTPClientRequest $request,
        Throwable $exception,
        array $context = []
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->exception = $exception;
    }

    public function getName(): string
    {
        return HTTPClientEvent::REQUEST_FAILED;
    }

    public function getException(): Throwable
    {
        return $this->exception;
    }

    public function getRequest(): HTTPClientRequest
    {
        return $this->request;
    }
}
