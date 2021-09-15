<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBucketsTable
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */
class CreateBucketsTable extends Migration
{
    /**
     * @const string
     */
    public const TABLE_NAME = 'buckets';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained(CreateBoardsTable::TABLE_NAME)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->boolean('archived')->default(false);
            $table->boolean('is_sprint')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
