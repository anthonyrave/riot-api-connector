<?php

namespace RiotApiConnector\Services;

class RiotApiService
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiToken,
    ) {
    }
}
