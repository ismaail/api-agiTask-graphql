<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Domain\User\Models\User;
use Domain\Board\Models\Board;
use Illuminate\Support\Facades\DB;
use Domain\Board\Models\Relation;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function auth_user_can_see_only_his_own_boards(): void
    {
        // Create First User with Boards
        User::factory()
            ->count(1)
            ->create(['id' => 1]);

        // Mock Login
        // (must be done before creation of the Boards which calls Board::booted() method)
        $authUser = User::first();
        $this->be($authUser);

        // Create Boards for First User
        Board
            ::factory()
            ->count(2)
            ->hasAttached(
                $authUser,
                ['relation' => Relation::OWNER],
                'members',
            )
            ->create();

        // Create extra Boards
        Board
            ::factory()
            ->count(3)
            ->hasAttached(
                User::factory(),
                ['relation' => Relation::OWNER],
                'members',
            )
            ->create();

        $users = User::all();
        $this->assertCount(4, $users);

        $boards = Board::all();
        $this->assertCount(2, $boards, '😮 Wrong number of Boards for Login User');

        $totalBoards = DB::table('boards')->count();
        $this->assertEquals(5, $totalBoards, '😮 Wrong Total number of Boards');
    }
}
