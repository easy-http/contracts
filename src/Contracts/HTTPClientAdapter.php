<?php

namespace EasyHTTP\Contracts\Contracts;

use EasyHTTP\Contracts\Exceptions\HTTPClientException;

interface HTTPClientAdapter
{
    /**
     * @param HTTPClientRequest $request
     * @return HTTPClientResponse
     * @throws HTTPClientException
     */
    public function request(HTTPClientRequest $request): HTTPClientResponse;

    /**
     * @param HTTPClientRequest $request
     * @return HTTPStreamResponse
     * @throws HTTPClientException
     */
    public function stream(HTTPClientRequest $request): HTTPStreamResponse;
}
