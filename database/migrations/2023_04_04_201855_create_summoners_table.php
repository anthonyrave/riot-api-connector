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
            $table->string('summonerId');
            $table->string('accountId');
            $table->string('puuid');
            $table->string('name');
            $table->integer('profileIconId');
            $table->timestamp('revisionDate');
            $table->integer('summonerLevel');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('summoners');
    }
};
