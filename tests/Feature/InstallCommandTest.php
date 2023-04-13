<?php

use function Pest\Laravel\artisan;

it('can run riot-api-connector:install successfully', function () {
    artisan('riot-api-connector:install')->expectsOutput('Riot API connector installed successfully.');
});