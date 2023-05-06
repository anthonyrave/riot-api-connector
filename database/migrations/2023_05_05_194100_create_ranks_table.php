<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('league_id');
            $table->foreignId('summoner_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('queue_type');
            $table->string('tier');
            $table->string('rank');
            $table->integer('league_points');
            $table->integer('wins');
            $table->integer('losses');
            $table->boolean('hot_streak');
            $table->boolean('veteran');
            $table->boolean('fresh_blood');
            $table->boolean('inactive');
            $table->timestamps();

            $table->unique(['summoner_id', 'queue_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};
