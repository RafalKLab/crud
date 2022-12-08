<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use Rklab\Crud\dto\CrudParametersTransfer;

class DtoMapper implements DataMapperInterface
{
    public function mapMigrationParametersToDto(CrudParametersTransfer $transfer, Request $request,): CrudParametersTransfer
    {
        $transfer->setTableName($request->input('tableName'));
        $transfer->setModelName($request->input('modelName'));
        $arr = [];
        $iterrator = (int) $request->input('fieldItterator');


        for ($i = 1; $i <= $iterrator; $i++) {
            $field = 'field_' . $i;
            $select = 'select_'. $i;

            $key = $request->input($field);
            $value = $request->input($select);

            $arr[$key] = $value;
        }

        $transfer->setTableFields($arr);

        return $transfer;
    }
}
