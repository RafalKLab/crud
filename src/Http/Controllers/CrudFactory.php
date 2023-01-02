<?php

namespace Rklab\Crud\Http\Controllers;

use JetBrains\PhpStorm\Pure;
use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Http\Controllers\Config\CrudConfig;
use Rklab\Crud\Http\Controllers\Generator\Controller\ControllerGenerator;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorCollection;
use Rklab\Crud\Http\Controllers\Generator\Migration\MigrationGenerator;
use Rklab\Crud\Http\Controllers\Generator\Model\ModelGenerator;
use Rklab\Crud\Http\Controllers\Generator\View\ViewGenerator;
use Rklab\Crud\Http\Controllers\Mapper\DtoMapper;
use Rklab\Crud\Http\Controllers\ModelRelationshipManager\OneToManyRelationshipManager;
use Rklab\Crud\Http\Controllers\Repository\Repository;
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
        return new DtoMapper(
            $this->getRepository(),
        );
    }

    #[Pure] public function createModelGenerator(): ModelGenerator
    {
        return new ModelGenerator(
            $this->createFileWriter()
        );
    }

    #[Pure] public function createControllerGenerator(): ControllerGenerator
    {
        return new ControllerGenerator(
            $this->createFileWriter(),
            $this->createCrudConfig(),
        );
    }

    #[Pure] public function createViewGenerator(): ViewGenerator
    {
        return new ViewGenerator(
            $this->createFileWriter()
        );
    }

    public function getGeneratorCollection(): CrudGeneratorCollection
    {
        return $this->createCrudGeneratorCollection();
    }

    private function createCrudGeneratorCollection(): CrudGeneratorCollection
    {
        return (new CrudGeneratorCollection)
            ->addGenerator($this->createMigrationGenerator())
            ->addGenerator($this->createModelGenerator())
            ->addGenerator($this->createControllerGenerator())
            ->addGenerator($this->createViewGenerator());
    }

    #[Pure] public function createCrudConfig(): CrudConfig
    {
        return new CrudConfig();
    }

    #[Pure] public function createModelRelationshipTransfer(): ModelRelationshipTransfer
    {
        return new ModelRelationshipTransfer();
    }

    #[Pure] private function getRepository(): Repository
    {
        return new Repository();
    }

    #[Pure] public function createOneToManyRelationshipManager(): OneToManyRelationshipManager
    {
        return new OneToManyRelationshipManager(
            $this->createFileWriter(),
            $this->createMigrationGenerator(),
        );
    }
}
