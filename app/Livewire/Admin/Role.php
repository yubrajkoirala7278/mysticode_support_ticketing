<?php

namespace App\Livewire\Admin;

use App\Models\Role as ModelsRole;
use Livewire\Component;
use Livewire\WithPagination;

class Role extends Component
{
    use WithPagination;
    // ========properties===========
    public $name;
    public $role_id = null;

    // ========validation==========
    function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role_id,
        ];
    }

    // ===========reset fields=====
    public function resetFields()
    {
        $this->reset('name', 'role_id');
        $this->resetErrorBag();
    }

    // =======render============
    public function render()
    {
        $roles = ModelsRole::latest()->paginate(10);
        return view('livewire.admin.role', [
            'roles' => $roles
        ]);
    }

    // ==========store===============
    public function store()
    {
        $validatedData = $this->validate();
        try {
            ModelsRole::create([
                'name' => $validatedData['name'],
                'guard_name' => 'web'
            ]);
            $this->dispatch('success', title: 'Role created successfully!');
            // reset fields
            $this->resetFields();
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // ========destroy=======
    public function delete($id)
    {
        try {
            ModelsRole::where('id', $id)->delete();
            $this->dispatch('delete', title: 'Role deleted successfully!');
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }

    // ==============update============
    public function edit($id)
    {
        $this->role_id = $id;
        try {
            $role = ModelsRole::findOrFail($id);
            $this->name = $role->name;
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
    public function update()
    {
        $validatedData = $this->validate();
        try {
            if ($this->role_id) {
                $role = ModelsRole::findOrFail($this->role_id);
                $role->update($validatedData);
                $this->dispatch('success', title: 'Role updated successfully!');
                $this->resetFields();
            }
        } catch (\Throwable $th) {
            $this->dispatch('error', title: $th->getMessage());
        }
    }
}
