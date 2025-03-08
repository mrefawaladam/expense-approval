<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
