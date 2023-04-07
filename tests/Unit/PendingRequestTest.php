<?php

use RiotApiConnector\Http\Requests\PendingRequest;

it('can handle server limited requests', function () {
    $pendingRequest = new PendingRequest(
        endpoint: '/',
        server: 'euw1'
    );
    $baseUrl = callMethod($pendingRequest, 'getBaseUrl');
    expect($baseUrl)
        ->toBe('https://euw1.'.config('riot_api_connector.url'));
});

it('can handle not server limited requests', function () {
    $pendingRequest = new PendingRequest(endpoint: '/');
    $baseUrl = callMethod($pendingRequest, 'getBaseUrl');
    expect($baseUrl)->toBe('https://'.config('riot_api_connector.url'));
});
