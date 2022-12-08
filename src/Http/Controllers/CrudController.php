<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CrudController extends Controller
{
    public function create()
    {
        return view("crud::crud.migration_step");
    }

    public function store(Request $request)
    {
        $transfer = $this->getCrudFactory()->createDtoMapper()->mapMigrationParametersToDto(
            $this->getCrudFactory()->createMigrationTableParametersTransfer(),
            $request,
        );

        $this->getCrudFactory()->createMigrationGenerator()->generateMigration($transfer);
        $this->getCrudFactory()->createModelGenerator()->generateModel($transfer);


        Artisan::call('migrate');

        return view("crud::dashboard.index");
    }
}
