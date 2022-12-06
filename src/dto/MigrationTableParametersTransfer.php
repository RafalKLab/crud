<?php

namespace Rklab\Crud\dto;

class MigrationTableParametersTransfer
{
    private string $tableName;
    private array $tableFields;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @return array
     */
    public function getTableFields(): array
    {
        return $this->tableFields;
    }

    /**
     * @param array $tableFields
     */
    public function setTableFields(array $tableFields): void
    {
        $this->tableFields = $tableFields;
    }
}
