<?php

namespace Rklab\Crud\Http\Controllers\Generator\View;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorInterface;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class ViewGenerator implements CrudGeneratorInterface
{
    private FileWriterInterface $writer;

    /**
     * ViewGenerator constructor.
     *
     * @param FileWriterInterface $writer
     */
    public function __construct(FileWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function generate(CrudParametersTransfer $transfer): void
    {
        $this->generateIndex($transfer);
        $this->generateForm($transfer);
        $this->generateShow($transfer);
    }

    private function generateIndex(CrudParametersTransfer $transfer): void
    {
        $modelName = $transfer->getModelName();
        $modelNameLowercase = strtolower($modelName);

        $indexFile = file_get_contents(__DIR__.'/skeleton/index-skeleton.txt');

        $indexFile = str_replace('{{model name lowercase}}', $modelNameLowercase, $indexFile);

        $fieldNames = '';
        $fieldData = '';
        /** @var FieldTransfer $field */
        foreach ($transfer->getTableFields() as $field) {
            $fieldNames .= sprintf('<th scope="col">%s</th>', $field->getFieldName());
            $fieldData .= sprintf('<td>{{$%s->%s}}</td>', $modelNameLowercase, $field->getFieldName());
        }

        $indexFile = str_replace('{{table fields}}', $fieldNames, $indexFile);
        $indexFile = str_replace('{{table fields data}', $fieldData, $indexFile);

        $path = resource_path();
        $path = $path.'/views/'.$modelName.'/'.'index.blade.php';

        $this->writer->createDirectory($path);
        $this->writer->putTextInFile($path, $indexFile);
    }

    private function generateShow(CrudParametersTransfer $transfer): void
    {
        $modelName = $transfer->getModelName();
        $modelNameLowercase = strtolower($modelName);

        $showFile = file_get_contents(__DIR__.'/skeleton/show-skeleton.txt');
        $showFile = str_replace('{{model name lowercase}}', $modelNameLowercase, $showFile);

        $modelFields = '';
        $modelFieldsData = '';

        /** @var FieldTransfer $field */
        foreach ($transfer->getTableFields() as $field) {
            $modelFields .= sprintf("<th scope='col'>%s</th>", $field->getFieldName());
            $modelFieldsData .= sprintf('<td>{{$%s->%s}}</td>', $modelNameLowercase, $field->getFieldName());
        }
        $showFile = str_replace('{{model fields}}', $modelFields, $showFile);
        $showFile = str_replace('{{model fields data}}', $modelFieldsData, $showFile);

        $path = resource_path();
        $path = $path.'/views/'.$modelName.'/'.'show.blade.php';

        $this->writer->createDirectory($path);
        $this->writer->putTextInFile($path, $showFile);
    }

    private function generateForm(CrudParametersTransfer $transfer): void
    {
        $modelName = $transfer->getModelName();
        $modelNameLowercase = strtolower($modelName);

        $formFile = file_get_contents(__DIR__.'/skeleton/form-skeleton.txt');
        $formFile = str_replace('{{model name lowercase}}', $modelNameLowercase, $formFile);

        $formInputs = '';
        /** @var FieldTransfer $field */
        foreach ($transfer->getTableFields() as $field) {
            $fieldName = $field->getFieldName();
            $formInputs .= '<div class="row">';
            $formInputs .= "\n";
            $formInputs .= sprintf("<label for=\"%s\" class='col-sm-2 col-form-label '>%1\$s: </label>", $fieldName);
            $formInputs .= "\n";
            $formInputs .= '<div class="col-sm-6">';
            $formInputs .= "\n";

            switch ($field->getFieldType()) {
                case 'date':
                    $formInputs .= $this->putInputTypeDate($field, $modelNameLowercase);
                    break;
                case 'text':
                    $formInputs .= $this->putTextArea($field, $modelNameLowercase);
                    break;
                default:
                    $formInputs .= $this->putInputTypeText($field, $modelNameLowercase);
            }

            $formInputs .= sprintf("@if(\$errors->has('%s'))", $fieldName);
            $formInputs .= '<span class="text-danger">';
            $formInputs .= sprintf("{{\$errors->first('%s')}}", $fieldName);
            $formInputs .= '</span>';
            $formInputs .= '@endif';
            $formInputs .= "\n";
            $formInputs .= '</div></div><br>';
        }

        $formFile = str_replace('{{form inputs}}', $formInputs, $formFile);

        $path = resource_path();
        $path = $path.'/views/'.$modelName.'/'.'form.blade.php';

        $this->writer->createDirectory($path);
        $this->writer->putTextInFile($path, $formFile);
    }

    /**
     * @param FieldTransfer $field
     * @param string        $modelNameLowercase
     *
     * @return string
     */
    private function putInputTypeText(FieldTransfer $field, string $modelNameLowercase): string
    {
        $fieldName = $field->getFieldName();

        $formInputs = '';
        $formInputs .= sprintf("<input type='text' class='form-control' name='%s' id='%s'", $fieldName, $fieldName);
        $formInputs .= "\n";
        $formInputs .= sprintf("value='@isset($%s){{ $%s->%s }}@endisset", $modelNameLowercase, $modelNameLowercase, $fieldName);
        $formInputs .= "\n";
        $formInputs .= sprintf("{{Request::old('%s') ? : ''}}'>", $fieldName);

        return $formInputs;
    }

    /**
     * @param FieldTransfer $field
     * @param string        $modelNameLowercase
     *
     * @return string
     */
    private function putInputTypeDate(FieldTransfer $field, string $modelNameLowercase): string
    {
        $fieldName = $field->getFieldName();

        $formInputs = '';
        $formInputs .= sprintf("<input type='date' class='form-control' name='%s' id='%s'", $fieldName, $fieldName);
        $formInputs .= "\n";
        $formInputs .= sprintf(
            "value='@isset($%s){{ \Carbon\Carbon::parse( $%s->%s )->format('Y-m-d') }}@endisset'>",
            $modelNameLowercase,
            $modelNameLowercase,
            $fieldName
        );

        return $formInputs;
    }

    /**
     * @param FieldTransfer $field
     * @param string $modelNameLowercase
     *
     * @return string
     */
    private function putTextArea(FieldTransfer $field, string $modelNameLowercase): string
    {
        $fieldName = $field->getFieldName();

        $formInputs = '';
        $formInputs .= sprintf("<textarea class='form-control' name='%s' id='%s' rows='3'>", $fieldName, $fieldName);
        $formInputs .= sprintf("@isset($%s){{ $%s->%s }}@endisset", $modelNameLowercase, $modelNameLowercase, $fieldName);
        $formInputs .= sprintf("{{Request::old('%s') ? : ''}}", $fieldName);
        $formInputs .= '</textarea>';

        return $formInputs;
    }
}
