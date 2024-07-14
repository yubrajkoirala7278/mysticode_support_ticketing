<?php

namespace App\Repositories\Interfaces;

Interface UserRepositoryInterface{
    public function all($keyword);
    public function store($userRequest);
    public function update($userRequest,$user);
    public function destroy($user);
}