<?php

namespace Rklab\Crud\dto;

class CrudParametersTransfer
{
    private string $tableName;
    private string $modelName;

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName): void
    {
        $this->modelName = $modelName;
    }
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
