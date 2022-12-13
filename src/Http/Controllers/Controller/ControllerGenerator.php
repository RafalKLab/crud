<?php

namespace Rklab\Crud\Http\Controllers\Controller;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class ControllerGenerator
{
    private FileWriterInterface $writer;

    protected const ROUTE_SIGNATURE = "\nRoute::resource('/crud/%ss', \App\Http\Controllers\%sController::class);";

    public function __construct(FileWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function generateController(CrudParametersTransfer $transfer): void
    {
        $controllerFile = file_get_contents(__DIR__ . '/skeleton/controller-skeleton.txt');

        $modelName = $transfer->getModelName();
        $modelNamelowercase = strtolower($modelName);

        $controllerFile = str_replace('{{model name}}', $modelName, $controllerFile);
        $controllerFile = str_replace('{{model name lowercase}}', $modelNamelowercase, $controllerFile);


        $validation = '$this->validate($request, [' . "\n";

        /** @var FieldTransfer $field */
        foreach ($transfer->getTableFields() as $field) {
            $rule = sprintf("'%s' => '", $field->getFieldName());
            foreach ($field->getFieldValidations() as $fieldValidation) {
                $rule .= match ($fieldValidation) {
                    'required' => 'required|',
                    'unique' => sprintf('unique:%s|', $transfer->getTableName()),
                };
            }

            $rule .= match ($field->getFieldType()) {
                'int' => "numeric',",
                'string' => "max:255',",
            };

            $rule .= "\n";

            $validation .= $rule;

        }
            $validation .= ']);';

        $controllerFile = str_replace('{{validation}}', $validation, $controllerFile);


            $path = app_path();
            $path = $path . '/Http/Controllers/' . $modelName . 'Controller.php';

            $this->writer->createDirectory($path);
            $this->writer->putTextInFile($path, $controllerFile);

            $routePath = base_path('routes/web.php');
            $routes = file_get_contents($routePath);

            $routes .= sprintf(self::ROUTE_SIGNATURE, $modelNamelowercase, $modelName);

            $this->writer->putTextInFile($routePath, $routes);

    }
}
