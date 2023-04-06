<?php

namespace RiotApiConnector\Http\Requests;

abstract class AbstractRequest
{
    public function __construct(
        protected readonly ?string $server = null
    ) {
    }

    protected function withServer(string $endpoint, array $urlParams = []): PendingRequest
    {
        return new PendingRequest($endpoint, $urlParams, $this->server);
    }

    protected function withoutServer(string $endpoint, array $urlParams = []): PendingRequest
    {
        return new PendingRequest($endpoint, $urlParams);
    }
}
