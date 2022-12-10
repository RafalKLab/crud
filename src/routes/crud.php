<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::get('/crud', function () {
        return view('crud::dashboard.index');
    })->name('dashboard');

    Route::get('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'prepareCrud'])->name('generate');
    Route::post('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'generateCrud']);

    Route::get('/crud/prepare', [\Rklab\Crud\Http\Controllers\CrudController::class, 'prepareFields'])->name('prepare');
    Route::post('/crud/prepare', [\Rklab\Crud\Http\Controllers\CrudController::class, 'generateFields']);
});
