<?php

namespace RiotApiConnector\Http\Requests;

abstract class AbstractRequest
{
    public function __construct(private readonly string $server)
    {
    }

    public function get()
    {
    }
}
