<?php

use function Pest\Laravel\artisan;

it('returns an error message if data type asked is unknown', function (string $dataType) {
    expect(artisan('riot-api-connector:fetch --data='.$dataType))
        ->toContain('Data of type "', '" does not exist.');

})->with([
    'qazertaze',
]);
