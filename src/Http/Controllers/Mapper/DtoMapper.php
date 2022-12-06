<?php

namespace Rklab\Crud\Http\Controllers\Mapper;

use Illuminate\Http\Request;
use Rklab\Crud\dto\MigrationTableParametersTransfer;

class DtoMapper implements DataMapperInterface
{
    public function mapMigrationParametersToDto(MigrationTableParametersTransfer $transfer, Request $request,): MigrationTableParametersTransfer
    {
        $transfer->setTableName($request->input('tableName'));
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
