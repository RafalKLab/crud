<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use Rklab\Crud\dto\CrudParametersTransfer;

interface DataMapperInterface
{
    public function mapMigrationParametersToDto(CrudParametersTransfer $transfer, Request $request): CrudParametersTransfer;
}
