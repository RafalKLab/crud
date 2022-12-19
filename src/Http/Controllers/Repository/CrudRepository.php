<?php

namespace Rklab\Crud\Http\Controllers\Repository;

use Illuminate\Database\Eloquent\Collection;
use Rklab\Crud\Models\Crud;

class CrudRepository
{
    /**
     * @return Collection
     */
    public function getCruds(): Collection
    {
        return Crud::all();
    }

    public function getCrudById(int $id)
    {
        return Crud::find($id);
    }
}
