<?php

namespace RiotApiConnector\Http\Requests;

abstract class AbstractRequest
{
    protected string $endpoint;

    public function __construct(
        private readonly string $server
    ) {
    }
}
