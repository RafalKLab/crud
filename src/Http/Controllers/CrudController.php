<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Rklab\Crud\dto\CrudParametersTransfer;
use Rklab\Crud\Http\Controllers\Generator\CrudGeneratorInterface;
use Rklab\Crud\Models\Crud;

class CrudController extends Controller
{
    public function prepareFields()
    {
        return view('crud::crud.crud_fields');
    }

    public function generateFields(Request $request)
    {
        $this->validate($request, [
            'number_of_fields' => 'numeric|min:1|max:20',
        ]);
        Session::put('number_of_fields', $request->input('number_of_fields'));

        return redirect()->route('generate');
    }


    public function prepareCrud()
    {
        return view("crud::crud.crud_settings");
    }

    public function generateCrud(Request $request)
    {
        for ($i = 1; $i <= $request->input('fieldItterator'); $i++) {
            $fieldName = 'field_name_' . $i;
            $selectType = 'select_type_' . $i;
            $this->validate($request, [
                $fieldName => 'required|alpha_dash|max:100',
                $selectType => 'required|alpha_dash|max:100',
                'table_name' => 'required|alpha|max:25|unique:cruds',
                'model_name' => 'required|alpha|max:25|unique:cruds',
            ]);
        }

        $transfer = $this->getTransfer($request);

        foreach ($this->getCrudGenerators() as $generator) {
            $generator->generate($transfer);
        }

        $this->saveCrud($transfer);

        Artisan::call('migrate');

        return redirect()->route('dashboard');
    }

    private function saveCrud(CrudParametersTransfer $transfer): void
    {
        $params = [
            'route' => sprintf("%ss.index", strtolower($transfer->getModelName())),
            'table_name' => $transfer->getTableName(),
            'model_name' => $transfer->getModelName(),
        ];

        Crud::create($params);
    }

    public function listCrud()
    {
        $cruds = Crud::paginate(2);

        return view('crud::crud.crud_list')->with('cruds', $cruds);
    }

    private function getTransfer(Request $request): CrudParametersTransfer
    {
        return $this->getCrudFactory()->createDtoMapper()->mapMigrationParametersToDto(
            $this->getCrudFactory()->createMigrationTableParametersTransfer(),
            $request,
        );
    }

    /**
     * @return CrudGeneratorInterface[]
     */
    private function getCrudGenerators(): array
    {
        return $this->getCrudFactory()
            ->getGeneratorCollection()
            ->getGenerators();
    }
}
