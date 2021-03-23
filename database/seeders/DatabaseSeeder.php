<?php

namespace Database\Seeders;

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

        $users = \App\Models\User::factory(1)->create();

        Project::factory(3)->create([
            'owner_id' => $users[0]->id,
        ]);
    }

    /**
     * Truncate all the tables.
     */
    private function truncateAllTable(): void
    {
        \DB::statement('TRUNCATE TABLE projects CASCADE');
        \DB::statement('TRUNCATE TABLE users CASCADE');
    }
}
