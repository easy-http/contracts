<?php

namespace EasyHTTP\Contracts\Events;

use EasyHTTP\Contracts\Constants\HTTPClientEvent;
use EasyHTTP\Contracts\Contracts\HTTPStreamResponse;

class StreamSucceeded extends AbstractHTTPClientEvent
{
    protected HTTPStreamResponse $response;

    /**
     * @param array $context
     */
    public function __construct(HTTPStreamResponse $response, array $context = [])
    {
        parent::__construct($context);
        $this->response = $response;
    }

    public function getName(): string
    {
        return HTTPClientEvent::STREAM_SUCCEEDED;
    }

    public function getResponse(): HTTPStreamResponse
    {
        return $this->response;
    }
}
