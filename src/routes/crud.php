<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::get('/crud', function () {
        return view('crud::dashboard.index');
    })->name('dashboard');

    Route::get('/crud/list', [\Rklab\Crud\Http\Controllers\CrudController::class, 'listCrud'])->name('crud.list');

    Route::get('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'prepareCrud'])->name('generate');
    Route::post('/crud/generate', [\Rklab\Crud\Http\Controllers\CrudController::class, 'generateCrud']);

    Route::get('/crud/prepare', [\Rklab\Crud\Http\Controllers\CrudController::class, 'prepareFields'])->name('prepare');
    Route::post('/crud/prepare', [\Rklab\Crud\Http\Controllers\CrudController::class, 'generateFields']);

    Route::get('/crud/relationship/create', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'createRelationship'])->name('relantionships');
    Route::post('/crud/relationship/create', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'storeRelationship']);

    Route::get('/crud/relationship/list', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'index'])->name('relationship.list');
    Route::get('/crud/relationship/show/{model}', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'show'])->name('relationship.show');

    Route::get('/crud/relationship/get/assign/table/{ref_model_name}/{aim_model_name}/{id}', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'getAssignTable'])->name('relationship.assign.table');

    Route::get('/crud/relationship/assign/{ref_model_name}/{ref_id}/{aim_model_name}/{aim_id}', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'assign'])->name('relationship.assign');
    Route::get('/crud/relationship/un-assign/{ref_model_name}/{ref_id}/{aim_model_name}/{aim_id}', [\Rklab\Crud\Http\Controllers\ModelRelationshipController::class, 'unAssign'])->name('relationship.unAssign');
});
