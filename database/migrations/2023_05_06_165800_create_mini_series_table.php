<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mini_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rank_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('losses');
            $table->string('progress');
            $table->integer('target');
            $table->integer('wins');
            $table->timestamps();

            $table->unique('rank_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mini_series');
    }
};
