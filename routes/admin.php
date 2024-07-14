<?php

use App\Http\Controllers\Admin\HomeController;
use App\Livewire\Admin\Role;
use App\Livewire\Admin\User;
use Illuminate\Support\Facades\Route;

Route::get('/home',[HomeController::class,'index'])->name('admin.home');

// roles
Route::get('/roles', Role::class)->name('admin.roles');
// users
Route::get('/users',User::class)->name('admin.users');