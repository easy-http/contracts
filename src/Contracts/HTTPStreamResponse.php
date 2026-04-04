<?php

namespace EasyHTTP\Contracts\Contracts;

use Generator;

interface HTTPStreamResponse
{
    public function getStatusCode(): int;
    public function getHeaders(): array;
    public function getBody(): Generator;
}
