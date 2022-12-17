<?php

namespace Rklab\Crud\Http\Controllers;

class CrudConfig
{
    protected const ROUTE_PREFIX = 'generated';

    public function getDefaultRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }
}
