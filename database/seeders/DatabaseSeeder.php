<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Board;
use App\Models\BoardMember;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateAllTable();

        User
            ::factory()
            ->count(1)
            ->hasAttached(
                Board::factory()->count(3),
                ['relation' => BoardMember::RELATION_OWNER],
                'boards'
            )
            ->create([
                'username' => 'doe',
                'email' => 'doe@example.com',
            ]);

        Board
            ::factory()
            ->count(7)
            ->hasAttached(
                User::factory(),
                ['relation' => BoardMember::RELATION_OWNER],
                'members',
            )->create();
    }

    /**
     * Truncate all the tables.
     */
    private function truncateAllTable(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        \DB::statement('TRUNCATE TABLE board_member');
        \DB::statement('TRUNCATE TABLE boards');
        \DB::statement('TRUNCATE TABLE users');

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
