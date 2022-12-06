<?php

namespace Rklab\Crud\Http\Controllers;

use JetBrains\PhpStorm\Pure;
use Rklab\Crud\dto\MigrationTableParametersTransfer;
use Rklab\Crud\Http\Controllers\Mapper\DtoMapper;
use Rklab\Crud\Http\Controllers\Migration\Generator\MigrationGenerator;
use Rklab\Crud\Http\Controllers\Writer\FileWriter;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class CrudFactory
{
    #[Pure] public function createMigrationGenerator(): MigrationGenerator
    {
        return new MigrationGenerator(
            $this->createFileWriter()
        );
    }

    #[Pure] public function createFileWriter(): FileWriterInterface
    {
        return new FileWriter();
    }

    #[Pure] public function createMigrationTableParametersTransfer(): MigrationTableParametersTransfer
    {
        return new MigrationTableParametersTransfer();
    }

    #[Pure] public function createDtoMapper(): DtoMapper
    {
        return new DtoMapper();
    }
}
