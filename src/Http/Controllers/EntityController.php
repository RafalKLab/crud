<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Http\Request;
use Rklab\Crud\Models\Entity;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::all();
        return view('crud::entity.index',[
            'entities' => $entities,
        ]);
    }
}
