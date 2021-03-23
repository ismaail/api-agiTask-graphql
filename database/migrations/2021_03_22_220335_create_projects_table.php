<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProjectsTable
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */
class CreateProjectsTable extends Migration
{
    /**
     * @const string
     */
    public const TABLE_NAME = 'projects';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('archived')->default(false);
            $table->foreignId('owner_id')
                ->constrained(CreateUsersTable::TABLE_NAME)
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
