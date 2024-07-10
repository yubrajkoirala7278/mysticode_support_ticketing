<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// =========frontend===========
require __DIR__.'/public.php';
// ========end of frontend=====

// ===========backend=========
Route::prefix('admin')->group(function(){
    require __DIR__.'/admin.php';
});
// ==========end of backend====