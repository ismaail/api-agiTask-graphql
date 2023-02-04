<?php

namespace Tests\App;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class ExampleTest extends TestCase
{
    #[Test]
    public function basic_test(): void
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }
}
