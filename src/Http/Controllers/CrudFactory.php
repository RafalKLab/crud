<?php

namespace Rklab\Crud\Http\Controllers;

use JetBrains\PhpStorm\Pure;
use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\Http\Controllers\Mapper\DtoMapper;
use Rklab\Crud\Http\Controllers\Migration\MigrationGenerator;
use Rklab\Crud\Http\Controllers\Model\ModelGenerator;
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

    #[Pure] public function createMigrationTableParametersTransfer(): CrudParametersTransfer
    {
        return new CrudParametersTransfer();
    }

    #[Pure] public function createDtoMapper(): DtoMapper
    {
        return new DtoMapper();
    }

    #[Pure] public function createModelGenerator(): ModelGenerator
    {
        return new ModelGenerator(
            $this->createFileWriter()
        );
    }
}
