<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('champion_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('champion_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->float('hp');
            $table->float('hpperlevel');
            $table->float('mp');
            $table->float('mpperlevel');
            $table->float('movespeed');
            $table->float('armor');
            $table->float('armorperlevel');
            $table->float('spellblock');
            $table->float('spellblockperlevel');
            $table->float('attackrange');
            $table->float('hpregen');
            $table->float('hpregenperlevel');
            $table->float('mpregen');
            $table->float('mpregenperlevel');
            $table->float('crit');
            $table->float('critperlevel');
            $table->float('attackdamage');
            $table->float('attackdamageperlevel');
            $table->float('attackspeedperlevel');
            $table->float('attackspeed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('champion_stats');
    }
};
