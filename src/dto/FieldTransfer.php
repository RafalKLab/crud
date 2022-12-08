<?php

namespace Rklab\Crud\dto;

class FieldTransfer
{
    private string $fieldName;
    private string $fieldType;
    private array $fieldValidations;

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFieldType(): string
    {
        return $this->fieldType;
    }

    /**
     * @param string $fieldType
     */
    public function setFieldType(string $fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldValidations(): array
    {
        return $this->fieldValidations;
    }

    /**
     * @param array $fieldValidations
     */
    public function setFieldValidations(array $fieldValidations)
    {
        $this->fieldValidations = $fieldValidations;

        return $this;
    }
}
