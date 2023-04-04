<?php

namespace RiotApiConnector\Contracts;

interface SummonerFactory
{
    public function byId(string $id);

    public function byPuuid(string $puuid);

    public function byName(string $name);

    public function byAccount(string $accountId);
}
