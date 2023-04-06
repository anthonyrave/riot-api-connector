<?php

namespace RiotApiConnector\Http\Requests;

class SummonerRequest extends AbstractRequest
{
    public function byId(string $id): SummonerRequest
    {
        $this->endpoint = config('');

        return $this;
    }

    public function byPuuid(string $puuid): SummonerRequest
    {
        return $this;
    }

    public function byName(string $name): SummonerRequest
    {
        return $this;
    }

    public function byAccount(string $accountId): SummonerRequest
    {
        return $this;
    }
}
