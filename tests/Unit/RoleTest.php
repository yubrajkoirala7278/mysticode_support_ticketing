<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser(array $attributes = [])
    {
        return User::factory()->create(array_merge([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function createRole(array $attributes = [])
    {
        return Role::create(array_merge([
            'name' => 'test-role',
        ], $attributes));
    }

    protected function deleteRole(Role $role)
    {
        $role->delete();
    }

    /** @test */
    public function it_can_create_a_role()
    {
        // Create a role
        $this->createRole();

        // Assert that the role exists
        $this->assertDatabaseHas('roles', ['name' => 'test-role']);
    }

    /** @test */
    public function it_can_add_a_role_to_a_user()
    {
        // Create user and role using helper methods
        $user = $this->createUser();
        $role = $this->createRole();

        // Assign role to user
        $user->assignRole($role->name);

        // Assert that the user has the role
        $this->assertTrue($user->hasRole('test-role'));
    }

    /** @test */
    public function it_can_retrieve_user_roles()
    {
        $user = $this->createUser();
        $role = $this->createRole();

        // Assign role to user
        $user->assignRole($role->name);

        // Retrieve user's roles
        $roles = $user->roles()->pluck('name')->toArray();

        // Assert that the user has the assigned role
        $this->assertTrue(in_array('test-role', $roles));
    }

    /** @test */
    public function it_can_update_user_roles()
    {
        // Create user, old role, and new role using helper methods
        $user = $this->createUser();
        $oldRole = $this->createRole(['name' => 'old-role']);
        $newRole = $this->createRole(['name' => 'new-role']);

        // Assign old role to user
        $user->assignRole($oldRole->name);

        // Assign new role to user
        $user->syncRoles([$newRole->name]);

        // Retrieve user's roles after update
        $roles = $user->roles()->pluck('name')->toArray();

        // Assert that the user has the updated role and not the old one
        $this->assertTrue(in_array('new-role', $roles));
        $this->assertFalse(in_array('old-role', $roles));
    }

    /** @test */
    public function it_can_delete_a_role()
    {
        $role = $this->createRole();
        $this->deleteRole($role);
        // Assert that the role no longer exists in the database
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
