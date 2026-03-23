<?php

namespace EasyHTTP\Contracts\Contracts;

use EasyHTTP\Contracts\Exceptions\ImpossibleToParseJsonException;

interface HTTPClientResponse
{
    public function getStatusCode(): int;
    public function getHeaders(): array;
    public function getBody(): string;

    /**
     * @return array
     * @throws ImpossibleToParseJsonException
     */
    public function parseJson(): array;
}
