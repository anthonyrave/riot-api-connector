<?php

namespace RiotApiConnector\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\RequestException;
use RiotApiConnector\Adapters\MasteryAdapter;
use RiotApiConnector\Exceptions\InvalidApiKeyException;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;

class MasteryRepository extends Repository
{
    protected string $model = Mastery::class;

    protected ?Champion $champion;

    protected ?Summoner $summoner;

    public function summoner(Summoner $summoner): static
    {
        $this->summoner = $summoner;
        $this->request->endpoint = config('riot.endpoints.mastery.default');
        $this->request->url_params['encryptedSummonerId'] = $this->summoner->summoner_id;
        $this->query->where('summoner_id', $this->summoner->id);
        return $this->collection();
    }

    public function byChampion(Champion $champion): static
    {
        $this->champion = $champion;
        $this->request->endpoint = config('riot.endpoints.mastery.by_champion');
        $this->request->url_params['championId'] = $this->champion->key;

        $this->query->where('champion_id', $champion->id);

        return $this->model();
    }

    public function top(?int $count = null): static
    {
        $this->request->endpoint = config('riot.endpoints.mastery.top');

        if ($count) {
            $this->request->endpoint .= '?count='.$count;
        }

        return $this->collection();
    }

    /**
     * @throws InvalidApiKeyException
     * @throws RequestException
     */
    public function fromApi(): Model|Collection
    {
        $data = $this->request->fetch();
        /** @var MasteryAdapter $adapter */
        $adapter = static::$adapter ?? self::resolveAdapterName(get_called_class());
        return $adapter::newFromApi($data, $this->summoner, $this->champion ?? null);
    }
}
