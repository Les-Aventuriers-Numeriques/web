<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('display_name');
            $table->string('avatar_url')->nullable();
            $table->boolean('is_member')->default(false);
            $table->boolean('is_lan_participant')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('must_relogin')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
