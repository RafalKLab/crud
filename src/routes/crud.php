<?php

use Illuminate\Support\Facades\Route;

Route::get('/crud', function () {
    return view('crud::dashboard.index');
});

Route::get('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'create'])->name('generate');
Route::post('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'store']);


