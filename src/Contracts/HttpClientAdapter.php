<?php

namespace EasyHttp\Contracts\Contracts;

use EasyHttp\Contracts\Exceptions\HttpClientException;

interface HttpClientAdapter
{
    /**
     * @param HttpClientRequest $request
     * @return HttpClientResponse
     * @throws HttpClientException
     */
    public function request(HttpClientRequest $request): HttpClientResponse;
}
