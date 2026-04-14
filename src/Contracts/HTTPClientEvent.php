<?php

namespace EasyHTTP\Contracts\Contracts;

interface HTTPClientEvent
{
    public function getName(): string;
    public function getContext(): array;
}
