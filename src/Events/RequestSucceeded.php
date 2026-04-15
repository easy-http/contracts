<?php

namespace EasyHTTP\Contracts\Events;

use EasyHTTP\Contracts\Constants\HTTPClientEvent;
use EasyHTTP\Contracts\Contracts\HTTPClientResponse;

class RequestSucceeded extends AbstractHTTPClientEvent
{
    protected HTTPClientResponse $response;

    /**
     * @param array $context
     */
    public function __construct(HTTPClientResponse $response, array $context = [])
    {
        parent::__construct($context);
        $this->response = $response;
    }

    public function getName(): string
    {
        return HTTPClientEvent::REQUEST_SUCCEEDED;
    }

    public function getResponse(): HTTPClientResponse
    {
        return $this->response;
    }
}
