<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::latest()->paginate(10);
    }

    public function store($data){
        Role::create([
            'name' => $data['name'],
            'guard_name' => 'web'
        ]);
    }

    public function find($id){
        return  Role::findOrFail($id);
    }

    public function update($role,$data){
        $role->update($data);
    }

    public function destroy($role){
        $role->delete();
    }
}
