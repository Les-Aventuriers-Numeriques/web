<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name');
            $table->string('custom_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
