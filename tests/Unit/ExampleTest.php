<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class ExampleTest extends TestCase
{
    /**
     * Test basic assertion.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test string manipulation.
     */
    public function test_string_contains_substring(): void
    {
        $string = 'Laravel Testing';

        $this->assertStringContainsString('Testing', $string);
        $this->assertEquals('LARAVEL TESTING', strtoupper($string));
    }

    /**
     * Test array operations.
     */
    public function test_array_has_key(): void
    {
        $data = ['name' => 'John', 'age' => 30];

        $this->assertArrayHasKey('name', $data);
        $this->assertEquals('John', $data['name']);
        $this->assertCount(2, $data);
    }

    /**
     * Test helper functions.
     */
    public function test_helper_functions(): void
    {
        $slug = Str::slug('Hello World');

        $this->assertEquals('hello-world', $slug);
        $this->assertTrue(Str::startsWith('Laravel', 'Lara'));
    }

    /**
     * Test calculation logic.
     */
    public function test_discount_calculation(): void
    {
        $price = 100;
        $discount = 20;
        $finalPrice = $price - ($price * $discount / 100);

        $this->assertEquals(80, $finalPrice);
    }

    /**
     * Test exception is thrown.
     */
    public function test_exception_is_thrown(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        throw new \InvalidArgumentException('Invalid input');
    }
}
