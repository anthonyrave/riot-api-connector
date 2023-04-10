<?php

use function Pest\Laravel\artisan;

it('can fetch data', function () {
    artisan('riot-api-connector:fetch --data=champions')
        ->expectsOutput();
});
