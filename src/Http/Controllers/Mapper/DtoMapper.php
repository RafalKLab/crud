<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Http\Controllers\Repository\CrudRepository;

class DtoMapper implements DataMapperInterface
{
    private CrudRepository $repository;

    /**
     * DtoMapper constructor.
     * @param CrudRepository $repository
     */
    public function __construct(CrudRepository $repository)
    {
        $this->repository = $repository;
    }

    public function mapMigrationParametersToDto(CrudParametersTransfer $transfer, Request $request,): CrudParametersTransfer
    {
        $transfer->setTableName($request->input('table_name'));
        $transfer->setModelName($request->input('model_name'));
        $transfer->setGenerateOption($request->input('generate_option'));
        $transfer->setRoutePrefix($request->input('route_prefix') ? : '');
        $arr = [];
        $validations = [];
        $iterrator = (int) $request->input('fieldItterator');

        for ($i = 1; $i <= $iterrator; $i++) {

            $fieldName = 'field_name_' . $i;
            $fieldType = 'select_type_'. $i;

            $require = 'required_' . $i;
            $unique = 'unique_' . $i;

            $rules = [];

            if ($request->input($require)) {
                $rules[] = 'required';
            }

            if ($request->input($unique)) {
                $rules[] = 'unique';
            }

            $fieldTransfer = (new FieldTransfer())
                ->setFieldName($request->input($fieldName))
                ->setFieldType($request->input($fieldType))
                ->setFieldValidations($rules);

            $arr[] = $fieldTransfer;
        }
        $transfer->setValidationRules($validations);
        $transfer->setTableFields($arr);

        return $transfer;
    }

    public function mapModelRelationshipToDto(ModelRelationshipTransfer $transfer, Request $request): ModelRelationshipTransfer
    {
        $aimModel = $this->repository->getCrudById($request->input('aim_model'));
        $transfer->setAimModelName($aimModel->model_name);
        $transfer->setAimModelTabeName($aimModel->table_name);

        $refModel = $this->repository->getCrudById($request->input('ref_model'));
        $transfer->setRefModelName($refModel->model_name);
        $transfer->setRefModelTableName($refModel->table_name);

        $transfer->setRelationType($request->input('relationship_type'));

        return $transfer;
    }
}
