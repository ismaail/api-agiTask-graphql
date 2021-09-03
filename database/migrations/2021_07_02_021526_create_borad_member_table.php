<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBoradMemberTable
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */
class CreateBoradMemberTable extends Migration
{
    /**
     * @const string
     */
    public const TABLE_NAME = 'board_member';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->foreignId('board_id')->constrained(CreateBoardsTable::TABLE_NAME)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('user_id')->constrained(CreateUsersTable::TABLE_NAME)
                ->onUpdate('cascade')->onDelete('restrict');

            $table->unsignedTinyInteger('relation');
            $table->timestamps();

            $table->unique(['board_id', 'user_id']);
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
