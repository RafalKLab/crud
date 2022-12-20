<?php

namespace Rklab\Crud\Http\Controllers\Repository;

use Illuminate\Database\Eloquent\Collection;
use Rklab\Crud\Models\Crud;
use Rklab\Crud\Models\RelatedModel;

class Repository
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

    public function getRelatedModels(): Collection
    {
        return RelatedModel::all();
    }
}
