<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Database\Eloquent\Model;
use RiotApiConnector\Adapters\MasteryAdapter;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;

class MasteryRepository extends Repository
{
    protected string $model = Mastery::class;

    protected ?Summoner $summoner;

    public function summoner(?Summoner $summoner = null): static
    {
        if ($summoner === null) {
            return $this;
        }

        $this->summoner = $summoner;
        $this->request->url_params['encryptedSummonerId'] = $this->summoner->summoner_id;
        $this->query->where('summoner_id', $this->summoner->id);

        $this->request->endpoint = config('riot.endpoints.mastery.default');

        return $this;
    }

    public function byChampion(int $championId): static
    {
        $this->request->endpoint = config('riot.endpoints.mastery.by_champion');
        $this->request->url_params['championId'] = $championId;

        $this->query->where('champion_id', $championId);

        return $this;
    }

    public function top(?int $count = null): static
    {
        $this->request->endpoint = config('riot.endpoints.mastery.top');

        if ($count) {
            $this->request->endpoint .= '?count='.$count;
        }

        return $this;
    }

    public function fromApi(): Model
    {
        $data = $this->request->fetch();
        /** @var MasteryAdapter $adapter */
        $adapter = static::$adapter ?? self::resolveAdapterName(get_called_class());
        return $adapter::newFromApi($data, $this->summoner);
    }
}
