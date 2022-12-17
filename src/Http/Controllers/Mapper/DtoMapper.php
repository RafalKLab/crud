<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\dto\FieldTransfer;

class DtoMapper implements DataMapperInterface
{
    public function mapMigrationParametersToDto(CrudParametersTransfer $transfer, Request $request,): CrudParametersTransfer
    {
        $transfer->setTableName($request->input('table_name'));
        $transfer->setModelName($request->input('model_name'));
        $transfer->setGenerateOption($request->input('generate_option'));
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
}
