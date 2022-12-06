<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use Rklab\Crud\dto\MigrationTableParametersTransfer;

interface DataMapperInterface
{
    public function mapMigrationParametersToDto(MigrationTableParametersTransfer $transfer, Request $request): MigrationTableParametersTransfer;
}
