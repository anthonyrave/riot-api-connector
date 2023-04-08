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
            $table->string('summoner_id');
            $table->string('account_id');
            $table->string('puuid');
            $table->string('name');
            $table->integer('profile_icon_id');
            $table->timestamp('revision_date');
            $table->integer('summoner_level');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('summoners');
    }
};
