<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Board;
use App\Models\Bucket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BoardMemberRelation;

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
                Board
                    ::factory()
                    ->count(3)
                    ->has(
                        Bucket::factory()->count(3),
                        'buckets',
                    ),
                ['relation' => BoardMemberRelation::OWNER],
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
                ['relation' => BoardMemberRelation::OWNER],
                'members',
            )
            ->has(
                Bucket::factory()->count(3),
                'buckets',
            )
            ->create();
    }

    /**
     * Truncate all the tables.
     */
    private function truncateAllTable(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::statement('TRUNCATE TABLE board_member');
        DB::statement('TRUNCATE TABLE buckets');
        DB::statement('TRUNCATE TABLE boards');
        DB::statement('TRUNCATE TABLE users');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
