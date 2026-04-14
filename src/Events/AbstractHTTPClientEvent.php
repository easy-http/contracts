<?php

namespace EasyHTTP\Contracts\Events;

use EasyHTTP\Contracts\Contracts\Observability\HTTPClientEvent;

abstract class AbstractHTTPClientEvent implements HTTPClientEvent
{
    protected array $context;

    /**
     * @param array $context
     */
    public function __construct(
        array $context = []
    ) {
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
