<?php

namespace RiotApiConnector\Providers;

use Illuminate\Support\Facades\Http;
use RiotApiConnector\Contracts\DataDragonProvider;

abstract class AbstractProvider implements DataDragonProvider
{
    public function update(): void
    {
        $response = $this->fetch();

        $this->mapDataToModels($response['data']);
    }

    protected function fetch(): array
    {
        return json_decode(Http::get($this->getUrl()), true);
    }

    abstract protected function mapDataToModels(array $data);

    abstract protected function getUrl(): string;
}
