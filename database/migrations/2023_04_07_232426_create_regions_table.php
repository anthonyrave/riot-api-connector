<?php

use Database\Seeders\RegionSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => RegionSeeder::class,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
