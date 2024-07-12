<?php

namespace App\Livewire\Admin;

use App\Models\Role as ModelsRole;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class Role extends Component
{
    use WithPagination;

    // ========properties===========
    private $roleRepository;
    public $name;
    public $id = null;

    // ========validation==========
    function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->id,
        ];
    }
    // =========boot========
    public function boot(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    // ===========reset fields=====
    public function resetFields()
    {
        $this->reset('name', 'id');
        $this->resetErrorBag();
    }


    // =======render============
    public function render()
    {
        $roles = $this->roleRepository->all();
        return view('livewire.admin.role', [
            'roles' => $roles
        ]);
    }

    // ==========store===============
    public function store()
    {
        $validatedData = $this->validate();
        try {
            $this->roleRepository->store($validatedData);
            $this->dispatch('success', title: 'Role created successfully!');
            // reset fields
            $this->resetFields();
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }


    // ==============update============
    public function edit(ModelsRole $role)
    {
        try {
            $this->id = $role->id;
            $this->name = $role->name;
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function update(ModelsRole $role)
    {
        $validatedData = $this->validate();
        try {
            $this->roleRepository->update($role, $validatedData);
            $this->dispatch('success', title: 'Role updated successfully!');
            $this->resetFields();
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // ========destroy=======
    public function destroy(ModelsRole $role)
    {
        try {
            $this->roleRepository->destroy($role);
            $this->dispatch('delete', title: 'Role deleted successfully!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
