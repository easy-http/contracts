<?php

namespace EasyHTTP\Contracts\Contracts;

use EasyHTTP\Contracts\Exceptions\HTTPJsonParseException;

interface HTTPClientResponse
{
    public function getStatusCode(): int;
    public function getHeaders(): array;
    public function getBody(): string;

    /**
     * @return array
     * @throws HTTPJsonParseException
     */
    public function parseJson(): array;
}
