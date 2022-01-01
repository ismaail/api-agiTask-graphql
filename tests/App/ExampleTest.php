<?php

namespace Tests\App;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ExampleTest
 * @package Tests\App
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function basic_test(): void
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }
}
