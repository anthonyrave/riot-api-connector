<?php

use GuzzleHttp\UriTemplate\UriTemplate;
use Illuminate\Support\Facades\Http;
use function Pest\Laravel\artisan;

//

it('can fetch data from DataDragon', function () {
    $championsUrl = UriTemplate::expand(config('data_dragon.data.champions'), [
        'version' => '13.7.1',
        'lang' => config('data_dragon.default.lang'),
    ]);

    Http::fake([
        config('data_dragon.data.versions') => Http::response(['13.7.1', '13.6.1'], '200'),
//        $championsUrl => Http::response('{"type":"champion","format":"standAloneComplex","version":"13.7.1","data":{"Aatrox":{"version":"13.7.1","id":"Aatrox","key":"266","name":"Aatrox","title":"the Darkin Blade","blurb":"Once honored defenders of Shurima against the Void, Aatrox and his brethren would eventually become an even greater threat to Runeterra, and were defeated only by cunning mortal sorcery. But after centuries of imprisonment, Aatrox was the first to find...","info":{"attack":8,"defense":4,"magic":3,"difficulty":4},"image":{"full":"Aatrox.png","sprite":"champion0.png","group":"champion","x":0,"y":0,"w":48,"h":48},"tags":["Fighter","Tank"],"partype":"Blood Well","stats":{"hp":650,"hpperlevel":114,"mp":0,"mpperlevel":0,"movespeed":345,"armor":38,"armorperlevel":4.45,"spellblock":32,"spellblockperlevel":2.05,"attackrange":175,"hpregen":3,"hpregenperlevel":1,"mpregen":0,"mpregenperlevel":0,"crit":0,"critperlevel":0,"attackdamage":60,"attackdamageperlevel":5,"attackspeedperlevel":2.5,"attackspeed":0.651}},"Ahri":{"version":"13.7.1","id":"Ahri","key":"103","name":"Ahri","title":"the Nine-Tailed Fox","blurb":"Innately connected to the magic of the spirit realm, Ahri is a fox-like vastaya who can manipulate her prey\'s emotions and consume their essence—receiving flashes of their memory and insight from each soul she consumes. Once a powerful yet wayward...","info":{"attack":3,"defense":4,"magic":8,"difficulty":5},"image":{"full":"Ahri.png","sprite":"champion0.png","group":"champion","x":48,"y":0,"w":48,"h":48},"tags":["Mage","Assassin"],"partype":"Mana","stats":{"hp":590,"hpperlevel":96,"mp":418,"mpperlevel":25,"movespeed":330,"armor":21,"armorperlevel":4.7,"spellblock":30,"spellblockperlevel":1.3,"attackrange":550,"hpregen":2.5,"hpregenperlevel":0.6,"mpregen":8,"mpregenperlevel":0.8,"crit":0,"critperlevel":0,"attackdamage":53,"attackdamageperlevel":3,"attackspeedperlevel":2,"attackspeed":0.668}}}', 200),
    ]);

    artisan('riot-api-connector:fetch')
        ->expectsOutput('Retrieving latest version...')
        ->expectsOutput('13.7.1');
});
