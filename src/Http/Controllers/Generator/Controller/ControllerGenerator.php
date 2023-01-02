<?php

namespace Rklab\Crud\Http\Controllers\Generator\Controller;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\Http\Controllers\Config\CrudConfig;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorInterface;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class ControllerGenerator implements CrudGeneratorInterface
{
    private FileWriterInterface $writer;

    private CrudConfig $config;

    protected const ROUTE_SIGNATURE = "\nRoute::resource('/%s/%ss', \App\Http\Controllers\%3\$s\%3\$sController::class);";

    /**
     * ControllerGenerator constructor.
     * @param FileWriterInterface $writer
     * @param CrudConfig $config
     */
    public function __construct(FileWriterInterface $writer, CrudConfig $config)
    {
        $this->writer = $writer;
        $this->config = $config;
    }


    public function generate(CrudParametersTransfer $transfer): void
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
                'int' => "numeric|min:1|max:2147483647',",
                'string' => "max:255',",
            };

            $rule .= "\n";

            $validation .= $rule;

        }
            $validation .= ']);';

        $controllerFile = str_replace('{{validation}}', $validation, $controllerFile);


            $path = app_path();
            $path = $path . sprintf("/Http/Controllers/%1\$s/%1\$sController.php", $modelName);

            $this->writer->createDirectory($path);
            $this->writer->putTextInFile($path, $controllerFile);

            $routePath = base_path('routes/web.php');
            $routes = file_get_contents($routePath);

            $routePrefix = $this->getRoutePrefix($transfer);

            $routes .= sprintf(self::ROUTE_SIGNATURE, $routePrefix, $modelNamelowercase, $modelName);

            $this->writer->putTextInFile($routePath, $routes);
    }

    private function getRoutePrefix(CrudParametersTransfer $transfer): string
    {
        return $transfer->getRoutePrefix() ? : $this->config->getDefaultRoutePrefix();
    }
}
