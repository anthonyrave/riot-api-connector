<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('summoners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('summoner_id')->unique();
            $table->string('account_id')->unique();
            $table->string('puuid')->unique();
            $table->string('name');
            $table->integer('profile_icon_id');
            $table->timestamp('revision_date');
            $table->integer('summoner_level');
            $table->timestamps();

            $table->unique('region_id', 'name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('summoners');
    }
};
