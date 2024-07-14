<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Helper method to create a user with default or provided attributes.
     *
     * @param array $attributes Additional user attributes (optional).
     * @return User
     */
    protected function createUser(array $attributes = [])
    {
        return User::factory()->create(array_merge([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $this->createUser();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_fetch_a_user()
    {
        $user = $this->createUser();

        $fetchedUser = User::find($user->id);

        $this->assertEquals($user->name, $fetchedUser->name);
        $this->assertEquals($user->email, $fetchedUser->email);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = $this->createUser();

        $updatedName = 'test two';
        $user->name = $updatedName;
        $user->save();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedName,
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = $this->createUser();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
