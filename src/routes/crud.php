<?php

use Illuminate\Support\Facades\Route;

Route::get('/crud', function () {
    return view('crud::dashboard.index');
});

Route::get('/crud/entities', [\Rklab\Crud\Http\Controllers\EntityController::class, 'index']);
