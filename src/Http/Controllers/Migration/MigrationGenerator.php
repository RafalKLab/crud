<?php

namespace Rklab\Crud\Http\Controllers\Migration;

use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class MigrationGenerator
{
    private FileWriterInterface $writer;

    /**
     * MigrationGenerator constructor.
     * @param FileWriterInterface $writer
     */
    public function __construct(FileWriterInterface $writer)
    {
        $this->writer = $writer;
    }


    public function generateMigration(CrudParametersTransfer $transfer)
    {
        $migrationFile = file_get_contents(__DIR__ . '/skeleton/migration-skeleton.txt');

        $upMethod = $this->addUpMethodHeader($transfer->getTableName());
        $upMethod .= $this->addFields($transfer->getTableFields());
        $upMethod .= $this->addUpMethodFooter();

        $downMethod = $this->addDownMethod($transfer->getTableName());

        $migrationFile = str_replace('{{% migration-up-method %}}', $upMethod, $migrationFile);
        $migrationFile = str_replace('{{% migration-down-method %}}', $downMethod, $migrationFile);

        $datePrefix = date('Y_m_d_His');

        $destination = database_path('/migrations/') . $datePrefix . '_create_' . $transfer->getTableName() . '_table.php';

        $this->writer->createDirectory($destination);
        $this->writer->putTextInFile($destination, $migrationFile);

    }

    private function addUpMethodHeader(string $tableName): string
    {
        return sprintf(
            "Schema::create('%s', function (Blueprint \$table) {
            \$table->id();",
            $tableName
        );
    }

    private function addFields(array $tableFields)
    {
        $fields = '';

        /** @var  $fieldTransfer */
        foreach ($tableFields as $fieldTransfer) {
            $field = match ($fieldTransfer->getFieldType()) {
                'int' => sprintf('$table->integer("%s"); ', $fieldTransfer->getFieldName()),
                'string' => sprintf('$table->string("%s"); ', $fieldTransfer->getFieldName()),
                'bool' => sprintf('$table->boolean("%s"); ', $fieldTransfer->getFieldName()),
            };
            $fields.=$field;
        }

        return $fields;
    }

    private function addUpMethodFooter(): string
    {
        return '
        $table->timestamps();
        });';
    }

    private function addDownMethod(string $tableName): string
    {
        return sprintf("Schema::dropIfExists('%s');", $tableName);
    }
}

