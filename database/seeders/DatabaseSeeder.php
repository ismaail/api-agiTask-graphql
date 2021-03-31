<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
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

        $users = User::factory(1)->create([
            'username' => 'jhon-doe',
            'email' => 'doe@example.com',
        ]);

        Project::factory(3)->create([
            'owner_id' => $users[0]->id,
        ]);
    }

    /**
     * Truncate all the tables.
     */
    private function truncateAllTable(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        \DB::statement('TRUNCATE TABLE projects');
        \DB::statement('TRUNCATE TABLE users');

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
