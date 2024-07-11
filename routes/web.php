<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



// =========frontend===========
require __DIR__.'/public.php';
// ========end of frontend=====

// ===========backend=========
Route::group(['middleware'=>['auth.admin']],function(){
    Route::prefix('admin')->group(function(){
        require __DIR__.'/admin.php';
    });
});
// ==========end of backend====