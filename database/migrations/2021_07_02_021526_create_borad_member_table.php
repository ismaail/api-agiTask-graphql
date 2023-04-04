<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('board_member', function (Blueprint $table) {
            $table->foreignId('board_id')->constrained('boards')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->unsignedTinyInteger('relation');
            $table->timestamps();

            $table->unique(['board_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('board_member');
    }
};
