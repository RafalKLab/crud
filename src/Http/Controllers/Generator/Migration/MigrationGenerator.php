<?php

namespace Rklab\Crud\Http\Controllers\Generator\Migration;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorInterface;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class MigrationGenerator implements CrudGeneratorInterface
{
    private FileWriterInterface $writer;

    /**
     * MigrationGenerator constructor.
     *
     * @param FileWriterInterface $writer
     */
    public function __construct(FileWriterInterface $writer)
    {
        $this->writer = $writer;
    }

    public function generate(CrudParametersTransfer $transfer): void
    {
        $migrationFile = file_get_contents(__DIR__.'/skeleton/migration-skeleton.txt');

        $upMethod = $this->addUpMethodHeader($transfer->getTableName());
        $upMethod .= $this->addFields($transfer->getTableFields());
        $upMethod .= $this->addUpMethodFooter();

        $downMethod = $this->addDownMethod($transfer->getTableName());

        $migrationFile = str_replace('{{% migration-up-method %}}', $upMethod, $migrationFile);
        $migrationFile = str_replace('{{% migration-down-method %}}', $downMethod, $migrationFile);

        $datePrefix = date('Y_m_d_His');

        $destination = database_path('/migrations/').$datePrefix.'_create_'.$transfer->getTableName().'_table.php';

        $this->writer->createDirectory($destination);
        $this->writer->putTextInFile($destination, $migrationFile);
    }

    public function generateRelationshipMigration(ModelRelationshipTransfer $transfer)
    {
        $aimModelNameLowercase = strtolower($transfer->getAimModelName());

        $migrationFile = file_get_contents(__DIR__.'/skeleton/one-to-many-migration-skeleton.txt');
        $migrationFile = str_replace('{{table name}}', $transfer->getRefModelTableName(), $migrationFile);

        $relationField = sprintf("\$table->unsignedBigInteger('%s_id')->nullable(); \n", $aimModelNameLowercase);
        $migrationFile = str_replace('{{relation field}}', $relationField, $migrationFile);

        $datePrefix = date('Y_m_d_His');
        $destination = database_path('/migrations/').$datePrefix.sprintf('_add_%s_relation_to_%s_table.php', $aimModelNameLowercase, $transfer->getRefModelTableName());

        $this->writer->createDirectory($destination);
        $this->writer->putTextInFile($destination, $migrationFile);
    }

    private function addUpMethodHeader(string $tableName): string
    {
        return sprintf(
            "Schema::create('%s', function (Blueprint \$table) {
            \$table->bigIncrements('id');",
            $tableName
        );
    }

    private function addFields(array $tableFields)
    {
        $fields = '';

        /** @var $fieldTransfer */
        foreach ($tableFields as $fieldTransfer) {
            $field = match ($fieldTransfer->getFieldType()) {
                'int'    => $this->putIntField($fieldTransfer),
                'string' => $this->putStringField($fieldTransfer),
                'date'   => $this->putDateField($fieldTransfer),
                'text'   => $this->putTextField($fieldTransfer),
            };
            $fields .= $field;
        }

        return $fields;
    }

    private function addUpMethodFooter(): string
    {
        return '
        $table->timestamps();
        });';
    }

    /**
     * @param string $tableName
     *
     * @return string
     */
    private function addDownMethod(string $tableName): string
    {
        return sprintf("Schema::dropIfExists('%s');", $tableName);
    }

    /**
     * @param FieldTransfer $fieldTransfer
     *
     * @return string
     */
    private function putIntField(FieldTransfer $fieldTransfer): string
    {
        $name = $fieldTransfer->getFieldName();
        $validations = $fieldTransfer->getFieldValidations();

        if (in_array('required', $validations)) {
            return sprintf('%s$table->integer("%s");', "\n", $name);
        } else {
            return sprintf('%s$table->integer("%s")->nullable();', "\n", $name);
        }
    }

    /**
     * @param FieldTransfer $fieldTransfer
     *
     * @return string
     */
    private function putStringField(FieldTransfer $fieldTransfer): string
    {
        $name = $fieldTransfer->getFieldName();
        $validations = $fieldTransfer->getFieldValidations();

        if (in_array('required', $validations)) {
            return sprintf('%s$table->string("%s");', "\n", $name);
        } else {
            return sprintf('%s$table->string("%s")->nullable();', "\n", $name);
        }
    }

    /**
     * @param FieldTransfer $fieldTransfer
     *
     * @return string
     */
    private function putDateField(FieldTransfer $fieldTransfer): string
    {
        $name = $fieldTransfer->getFieldName();
        $validations = $fieldTransfer->getFieldValidations();

        if (in_array('required', $validations)) {
            return sprintf('%s$table->date("%s");', "\n", $name);
        } else {
            return sprintf('%s$table->date("%s")->nullable();', "\n", $name);
        }
    }

    /**
     * @param FieldTransfer $fieldTransfer
     *
     * @return string
     */
    private function putTextField(FieldTransfer $fieldTransfer): string
    {
        $name = $fieldTransfer->getFieldName();
        $validations = $fieldTransfer->getFieldValidations();

        if (in_array('required', $validations)) {
            return sprintf('%s$table->text("%s");', "\n", $name);
        } else {
            return sprintf('%s$table->text("%s")->nullable();', "\n", $name);
        }
    }
}
