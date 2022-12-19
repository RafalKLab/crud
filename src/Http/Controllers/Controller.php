<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JetBrains\PhpStorm\Pure;
use Rklab\Crud\Http\Controllers\Repository\CrudRepository;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    #[Pure] public function getCrudFactory(): CrudFactory
    {
        return new CrudFactory();
    }

    #[Pure] public function getCrudRepository(): CrudRepository
    {
        return new CrudRepository();
    }
}
