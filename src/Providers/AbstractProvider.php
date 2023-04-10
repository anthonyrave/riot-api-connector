<?php

namespace RiotApiConnector\Providers;

use Illuminate\Support\Facades\Http;
use RiotApiConnector\Contracts\DataDragonProvider;

abstract class AbstractProvider implements DataDragonProvider
{
    public function update(string $version): void
    {
        $response = $this->fetch($version);

        $this->mapDataToModels($response['data']);
    }

    protected function fetch(string $version): array
    {
        $response = Http::withUrlParameters($this->getUrlParameters($version))->get($this->getUrl());

        return $response->json();
    }

    protected function getUrlParameters(string $version): array
    {
        return [
            'version' => $version,
            'lang' => $this->getLang(),
        ];
    }

    protected function getLocale(): string
    {
        return explode('_', $this->getLang(), 2)[0];
    }

    protected function getLang(): string
    {
        return config('data_dragon.default.lang');
    }

    abstract protected function getUrl(): string;

    abstract protected function mapDataToModels(array $data);
}
