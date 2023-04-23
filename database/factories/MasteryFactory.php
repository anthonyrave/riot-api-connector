<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RiotApiConnector\Models\Mastery;

class MasteryFactory extends Factory
{
    protected $model = Mastery::class;

    public function definition(): array
    {
        $maxLevel = count(config('riot.masteries') - 1);
        $level = fake()->numberBetween(0, $maxLevel);
        $pointsSinceLastLevel = $this->fakePointsSinceLastLevel($level);
        $pointsUntilNextLevel = $this->fakePointsUntilNextLevel($level, $pointsSinceLastLevel);

        return [
            'champion_level' => $level,
            'champion_points' => $this->fakeChampionPoints($level, $pointsSinceLastLevel),
            'last_play_time' => $level !== 0 ? fake()->dateTime() : null,
            'champion_points_since_last_level' => $pointsSinceLastLevel,
            'champion_points_until_next_level' => $pointsUntilNextLevel,
            'chest_granted' => $level === 0 || fake()->boolean(),
            'tokens_earned' => $this->fakeTokensEarned($level),
        ];
    }

    private function fakePointsSinceLastLevel(int $level): int
    {
        return fake()->numberBetween(0, config('riot.masteries')[$level]['required']);
    }

    private function fakePointsUntilNextLevel(int $level, int $points): int
    {
        return max(config('riot.masteries')[$level]['required'] - $points, 0);
    }

    private function fakeChampionPoints($level, $pointsSinceLastLevel): int
    {
        return config('riot.masteries')[$level]['cumulated'] + $pointsSinceLastLevel;
    }

    private function fakeTokensEarned(int $level): int
    {
        return fake()->numberBetween(0, config('riot.masteries')[$level]['tokens']);
    }
}