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
        $response = Http::withUrlParameters($this->getUrlParameters())->get($this->getUrl());

        return $response->json();
    }

    protected function getLastVersion(): string
    {
        $response = Http::get(config('data-dragon.data.versions'));

        return $response->json()[0];
    }

    abstract protected function mapDataToModels(array $data);

    abstract protected function getUrl(): string;

    protected function getUrlParameters(): array
    {
        return [
            'version' => $this->getLastVersion(),
            'lang' => config('data-dragon.default.lang'),
        ];
    }
}
