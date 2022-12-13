<?php

namespace Rklab\Crud\Http\Controllers\Generator;

use Rklab\Crud\dto\CrudParametersTransfer;

interface CrudGeneratorInterface
{
    public function generate(CrudParametersTransfer $transfer): void;
}
