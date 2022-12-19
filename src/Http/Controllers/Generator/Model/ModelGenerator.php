<?php

namespace Rklab\Crud\Http\Controllers\Generator\Model;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorInterface;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class ModelGenerator implements CrudGeneratorInterface
{
    private FileWriterInterface $writer;

    /**
     * ModelGenerator constructor.
     * @param FileWriterInterface $writer
     */
    public function __construct(FileWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function generate(CrudParametersTransfer $transfer): void
    {

        $modelFile = $this->getModelFileFromSkeleton();

        $modelFile = $this->replaceModelName($modelFile, $transfer->getModelName());
        $modelFile = $this->replaceTableName($modelFile, $transfer->getTableName());

        $fillable = $this->prepareFillableFields($transfer->getTableFields());
        $modelFile = $this->replaceFillable($modelFile, $fillable);

        $path = app_path();
        $path = $path . sprintf("/Models/%1\$s/%1\$s.php", $transfer->getModelName());

        $this->writer->createDirectory($path);
        $this->writer->putTextInFile($path, $modelFile);
    }

    private function getModelFileFromSkeleton(): string
    {
        return file_get_contents(__DIR__ . '/skeleton/model-skeleton.txt');
    }

    private function replaceTableName(string $modelFile, string $tableName): string
    {
        return str_replace('{{tableName}}', $tableName, $modelFile);
    }

    private function replaceModelName(string $modelFile, string $modelName): string
    {
        return str_replace('{{modelName}}', $modelName, $modelFile);
    }

    private function prepareFillableFields(array $tableFields): string
    {
        $fillable = "[";

        /** @var FieldTransfer $fieldTransfer */
        foreach ($tableFields as $fieldTransfer) {
            $fillable.= sprintf("'%s',", $fieldTransfer->getFieldName());
        }
        $fillable.="]" ;

        return $fillable;
    }

    private function replaceFillable(string $modelFile, string $fillable): string
    {
        return str_replace('{{fillable}}', $fillable, $modelFile);
    }
}
