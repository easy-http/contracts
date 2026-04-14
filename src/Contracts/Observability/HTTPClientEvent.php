<?php

namespace EasyHTTP\Contracts\Contracts\Observability;

interface HTTPClientEvent
{
    public function getName(): string;
    public function getContext(): array;
}
