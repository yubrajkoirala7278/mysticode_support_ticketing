<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User as ModelsUser;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // ==========properties=========
    public $name, $email, $password, $password_confirmation, $role, $roles = [], $id;
    public $search = '';
    private $userRepository;

    // =======validation===========
    function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'role' => 'required'
        ];
    }
    // =======reset fields====
    public function resetFields()
    {
        $this->reset('name', 'email', 'password', 'password_confirmation', 'role');
        $this->resetErrorBag();
    }

    // =========boot==========
    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // =========render=======
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = $this->userRepository->all($this->search);
        return view('livewire.admin.user', [
            'users' => $users,
        ]);
    }

    // =====store==========
    public function create()
    {
        $this->roles = Role::pluck('name');
    }
    public function store()
    {
        $validatedData = $this->validate();
        try {
            $this->userRepository->store($validatedData);
            $this->dispatch('success', title: 'User created successfully!');
            $this->resetFields();
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // ===============update============
    public function edit(ModelsUser $user)
    {
        try {
            $this->id = $user->id;
            $this->email = $user->email;
            $this->name = $user->name;
            $this->role = $user->getRoleNames()->first();
            $this->roles = Role::pluck('name');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    public function update(ModelsUser $user)
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->id,
            'role' => 'required'
        ]);
        try {
            $this->userRepository->update($validatedData, $user);
            $this->dispatch('success', title: 'User updated successfully!');
            $this->resetFields();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // =========destroy==========
    public function destroy(ModelsUser $user)
    {
        try {
            $this->userRepository->destroy($user);
            $this->dispatch('delete', title: 'User deleted successfully!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
