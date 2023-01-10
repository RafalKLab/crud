<?php

namespace Rklab\Crud\Http\Controllers\Config;

class CrudConfig
{
    public const ROUTE_PREFIX = 'generated';
    public const PAGINATION = 'pagination';
    public const CRUD_LIST = 'crud_list_pagination';
    public const CRUD_ELEMENTS_LIST = 'crud_elements_pagination';
    public const RELATIONSHIP_LIST = 'relationships_list_pagination';

    protected const DEFAULT_PAGINATION = 10;

    protected array $pagination;

    /**
     * CrudConfig constructor.
     */
    public function __construct()
    {
        $this->pagination = json_decode(file_get_contents(__DIR__.'/config.json'), true);
    }

    public function getDefaultRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }

    public function getDefaultPagination(): int
    {
        return self::DEFAULT_PAGINATION;
    }

    public function getCrudListPagination(): int
    {
        return $this->pagination[self::PAGINATION][self::CRUD_LIST] ? $this->pagination[self::PAGINATION][self::CRUD_LIST] : $this->getDefaultPagination();
    }

    public function getRelationshipListPaginaton(): int
    {
        return $this->pagination[self::PAGINATION][self::RELATIONSHIP_LIST] ? $this->pagination[self::PAGINATION][self::RELATIONSHIP_LIST] : $this->getDefaultPagination();
    }

    public function getCrudElementPagination(): int
    {
        return $this->pagination[self::PAGINATION][self::CRUD_ELEMENTS_LIST] ? $this->pagination[self::PAGINATION][self::CRUD_ELEMENTS_LIST] : $this->getDefaultPagination();
    }

    public function getPaginationData(): array
    {
        return $this->pagination;
    }
}
