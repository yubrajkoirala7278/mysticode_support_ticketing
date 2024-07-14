<?php

namespace App\Repositories\Interfaces;

Interface RoleRepositoryInterface{
    public function all();
    public function store($data);
    public function update($role,$data);
    public function destroy($role);
}