<?php

namespace Rklab\Crud\Http\Controllers\ModelRelationshipManager;

use Rklab\Crud\dto\ModelRelationshipTransfer;

interface ModelRelationshipManagerInterface
{
    public function createRealation(ModelRelationshipTransfer $transfer);
}
