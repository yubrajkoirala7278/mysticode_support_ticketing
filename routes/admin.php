<?php

use App\Http\Controllers\Admin\HomeController;
use App\Livewire\Admin\Role;
use Illuminate\Support\Facades\Route;

Route::get('/home',[HomeController::class,'index'])->name('admin.home');

// roles
Route::get('/roles', Role::class)->name('roles.index');