<?php

use function Pest\Laravel\artisan;

it('can fetch data from DataDragon', function () {
    artisan('riot-api-connector:fetch')
        ->expectsOutput('test');
});
