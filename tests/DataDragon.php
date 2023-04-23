<?php

use RiotApiConnector\Contracts\DataDragonProvider;
use RiotApiConnector\Facades\DataDragon;

it('may create a champions provider', function () {
    $championsProvider = DataDragon::driver('champions');

    expect($championsProvider)->toBeInstanceOf(DataDragonProvider::class);
});

it('may throw an error if driver is unknown', function () {
    expect(fn() => DataDragon::driver('unknown'))
        ->toThrow(InvalidArgumentException::class, 'Driver [unknown] not supported.');
});