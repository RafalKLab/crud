<?php

namespace Rklab\Crud\Http\Controllers\ModelRelationshipManager;

use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Http\Controllers\Generator\Migration\MigrationGenerator;
use Rklab\Crud\Http\Controllers\Writer\FileWriterInterface;

class OneToManyRelationshipManager implements ModelRelationshipManagerInterface
{
    private FileWriterInterface $writer;
    private MigrationGenerator $migrationGenerator;

    private const RELATIONSHIP_HEADING = "// model relationship";

    /**
     * OneToManyRelationshipManager constructor.
     * @param FileWriterInterface $writer
     * @param MigrationGenerator $migrationGenerator
     */
    public function __construct(FileWriterInterface $writer, MigrationGenerator $migrationGenerator)
    {
        $this->writer = $writer;
        $this->migrationGenerator = $migrationGenerator;
    }

    public function createRealation(ModelRelationshipTransfer $transfer)
    {
        // 1 step is to modify aim model
        $this->addRelationToAimModel($transfer);

        // 2 step is to modify ref model
        $this->addRelationToRedModel($transfer);

        // 3 add neccesary field in DB
        $this->migrationGenerator->generateRelationshipMigration($transfer);
    }

    private function addRelationToAimModel(ModelRelationshipTransfer $transfer): void
    {
        $path = app_path(sprintf("/Models/%1\$s/%1\$s.php", $transfer->getAimModelName()));
        $aimModelFile = file_get_contents($path);

        $functionContent = sprintf("public function %s(){", $transfer->getRefModelTableName());
        $functionContent .= sprintf("return \$this->hasMany(\App\Models\%1\$s\%1\$s::class);}", $transfer->getRefModelName());

        $aimModelFile = str_replace(self::RELATIONSHIP_HEADING, self::RELATIONSHIP_HEADING . "\n" . $functionContent, $aimModelFile);

        $this->writer->putTextInFile($path, $aimModelFile);
    }

    private function addRelationToRedModel(ModelRelationshipTransfer $transfer): void
    {
        $aimModelNameLowercase = strtolower($transfer->getAimModelName());

        $path = app_path(sprintf("/Models/%1\$s/%1\$s.php", $transfer->getRefModelName()));
        $refModelFile = file_get_contents($path);

        $functionContent = sprintf("public function %s(){", $aimModelNameLowercase);
        $functionContent .= sprintf("return \$this->belongsTo(\App\Models\%1\$s\%1\$s::class);}", $transfer->getAimModelName());

        $refModelFile = str_replace(self::RELATIONSHIP_HEADING, self::RELATIONSHIP_HEADING . "\n" . $functionContent, $refModelFile);

        $this->writer->putTextInFile($path, $refModelFile);
    }
}
