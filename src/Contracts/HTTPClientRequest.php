<?php

namespace EasyHTTP\Contracts\Contracts;

use EasyHTTP\Contracts\Contracts\BodyPayload\BodyPayloadContract;
use EasyHTTP\Contracts\Contracts\Request\HTTPSecurityContext;

interface HTTPClientRequest
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getHeader(string $key);

    /**
     * Returns an array of key -> value pairs of headers
     * Ex: ['Content-Type' => 'application/json;charset=UTF-8', 'Accept' => 'application/json']
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Returns the body payload.
     *
     * This interface defines a common way to get the body payload from the request.
     * Some examples of body payloads are:
     *
     * - strings
     * - resources
     * - iterables
     *
     * @return BodyPayloadContract|null
     */
    public function getBodyPayload(): ?BodyPayloadContract;

    /**
     * Returns an array of key -> value pairs of query parameters
     * Ex: ['foo' => 'bar', 'flag' => 'enabled']
     *
     * @return array
     */
    public function getQuery(): array;

    public function getTimeout(): int;
    public function getSecurityContext(): ?HTTPSecurityContext;

    /**
     * Returns an array with basic auth credentials.
     * The first value will be the username and the second one will be the password.
     * Ex: ['username', 'password']
     *
     * @return array
     */
    public function getBasicAuth(): array;

    public function hasHeaders(): bool;
    public function hasQuery(): bool;
    public function hasSecurityContext(): bool;
    public function hasBasicAuth(): bool;
    public function hasBodyPayload(): bool;

    public function setMethod(string $method): self;
    public function setUri(string $uri): self;
    public function setHeader(string $key, string $value): self;
    public function setHeaders(array $headers): self;
    public function setBodyPayload(BodyPayloadContract $bodyPayload): self;
    public function setQuery(array $query): self;

    public function setTimeout(int $timeout): self;
    public function setSecurityContext(HTTPSecurityContext $securityContext): self;
    public function setBasicAuth(string $username, string $password): self;

    /**
     * SSL Client Verification
     * We suggest this parameter will be false by default.
     *
     * @param bool $ssl
     * @return void
     */
    public function ssl(bool $ssl): self;
    public function isSSL(): bool;
}
