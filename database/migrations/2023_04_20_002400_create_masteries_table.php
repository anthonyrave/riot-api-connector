<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masteries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('champion_id')
                // TODO not sure this is a good idea
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('summoner_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('champion_level');
            $table->unsignedInteger('champion_points');
            $table->timestamp('last_play_time')->nullable();
            $table->unsignedInteger('champion_points_since_last_level');
            $table->unsignedInteger('champion_points_until_next_level');
            $table->boolean('chest_granted');
            $table->unsignedTinyInteger('tokens_earned');
            $table->timestamps();

            $table->unique('champion_id', 'summoner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masteries');
    }
};
