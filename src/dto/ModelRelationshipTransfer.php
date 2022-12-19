<?php

namespace Rklab\Crud\dto;

class ModelRelationshipTransfer
{
    private string $aimModelName;
    private string $aimModelTabeName;
    private string $refModelName;
    private string $refModelTableName;
    private string $relationType;

    /**
     * @return string
     */
    public function getRelationType(): string
    {
        return $this->relationType;
    }

    /**
     * @param string $relationType
     */
    public function setRelationType(string $relationType): void
    {
        $this->relationType = $relationType;
    }

    /**
     * @return string
     */
    public function getAimModelName(): string
    {
        return $this->aimModelName;
    }

    /**
     * @param string $aimModelName
     */
    public function setAimModelName(string $aimModelName): void
    {
        $this->aimModelName = $aimModelName;
    }

    /**
     * @return string
     */
    public function getAimModelTabeName(): string
    {
        return $this->aimModelTabeName;
    }

    /**
     * @param string $aimModelTabeName
     */
    public function setAimModelTabeName(string $aimModelTabeName): void
    {
        $this->aimModelTabeName = $aimModelTabeName;
    }

    /**
     * @return string
     */
    public function getRefModelName(): string
    {
        return $this->refModelName;
    }

    /**
     * @param string $refModelName
     */
    public function setRefModelName(string $refModelName): void
    {
        $this->refModelName = $refModelName;
    }

    /**
     * @return string
     */
    public function getRefModelTableName(): string
    {
        return $this->refModelTableName;
    }

    /**
     * @param string $refModelTableName
     */
    public function setRefModelTableName(string $refModelTableName): void
    {
        $this->refModelTableName = $refModelTableName;
    }
}
