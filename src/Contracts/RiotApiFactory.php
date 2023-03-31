<?php

namespace RiotApiConnector\Contracts;

interface RiotApiFactory
{
    public function get(string $url, array $params = [], bool $requiresServer = true): array;
}
