<?php

namespace EasyHTTP\Contracts\Events;

use EasyHTTP\Contracts\Constants\HTTPClientEvent;
use EasyHTTP\Contracts\Contracts\HTTPClientRequest;

class RequestStarted extends AbstractHTTPClientEvent
{
    protected HTTPClientRequest $request;

    /**
     * @param array $context
     */
    public function __construct(HTTPClientRequest $request, array $context = [])
    {
        parent::__construct($context);
        $this->request = $request;
    }

    public function getName(): string
    {
        return HTTPClientEvent::REQUEST_STARTED;
    }

    public function getRequest(): HTTPClientRequest
    {
        return $this->request;
    }
}
