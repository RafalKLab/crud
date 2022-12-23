<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Models\RelatedModel;

class ModelRelationshipController extends Controller
{
    public function index()
    {
        $relatedModels = $this->getRepository()->getRelatedModels();

        return view("crud::relationship.index")->with('relatedModels', $relatedModels);
    }

    public function show(RelatedModel $model)
    {
        $fullyQualifiedAimModelClassName = $this->getFullyQualifiedClassName($model->aim_model);

        $modelData = $fullyQualifiedAimModelClassName::all();
        if ($modelData) {
            $modelDataFieldNames = $modelData[0]->getFillable();

            return view("crud::relationship.show")->with(compact('modelData', 'modelDataFieldNames', 'model'));

        } else {
            return redirect()->route('dashboard')->with('warning','Model data not found!.');
        }
    }

    public function getAssignTable(Request $request)
    {
        $aimModelId = $request->id;
        $aimModel = $request->aim_model_name;
        $refModel = $request->ref_model_name;

        $aimModelField = sprintf("%s_id", strtolower($aimModel));
        $fullyQualifiedRefClassName = $this->getFullyQualifiedClassName($refModel);

        $assignedData = $fullyQualifiedRefClassName::where($aimModelField, $aimModelId)->get();
        $unAssignedData = $fullyQualifiedRefClassName::where($aimModelField, null)->get();

        $refModelRecords = $fullyQualifiedRefClassName::skip(0)->take(1)->get();
        if ($refModelRecords) {
           $refModelFieldNames = $refModelRecords[0]->getFillable();

           return view("crud::relationship.assign")->with(
               compact(
                   'assignedData',
                   'unAssignedData',
                   'refModelFieldNames',
                   'aimModelId',
                   'aimModel',
                   'refModel',
               )
           );
        } else {
            return redirect()->route('dashboard')->with('warning','Model data not found!.');
        }
    }

    public function assign(Request $request)
    {
        $fullyQualifiedRefClassName = $this->getFullyQualifiedClassName($request->ref_model_name);
        $aimModelField = sprintf("%s_id", strtolower($request->aim_model_name));
        $refModelId = $request->ref_id;
        $aimModelId = $request->aim_id;

        $fullyQualifiedRefClassName::where('id', $refModelId)->update([$aimModelField => $aimModelId]);

        return Redirect::back()->with('success',"Model object was assigned.");
    }

    public function unAssign(Request $request)
    {
        $fullyQualifiedRefClassName = $this->getFullyQualifiedClassName($request->ref_model_name);
        $aimModelField = sprintf("%s_id", strtolower($request->aim_model_name));
        $refModelId = $request->ref_id;
        $aimModelId = $request->aim_id;

        $fullyQualifiedRefClassName::where('id', $refModelId)->where($aimModelField, $aimModelId)
            ->update([$aimModelField => null]);

        return Redirect::back()->with('success',"Model object was unassigned.");
    }

    public function createRelationship()
    {
        $cruds = $this->getRepository()->getCruds();

        return view("crud::relationship.form")->with('cruds', $cruds);
    }

    public function storeRelationship(Request $request)
    {
        $this->validate($request, [
            'aim_model' => 'required',
            'relationship_type' => 'required',
            'ref_model' => 'required|different:aim_model',
        ]);

        $transfer = $this->getRelationshipTransfer($request);

        match ($request->input('relationship_type')) {
            '1:N' => $this->createOneToManyRelationship($transfer),
            'N:N' => $this->createManyToManyRelationship($transfer),
        };

        Artisan::call('migrate');

        $this->saveRelationEntry($transfer);

        return redirect()->route('dashboard')->with('success', 'New relation was created!');
    }

    private function createOneToManyRelationship(ModelRelationshipTransfer $transfer)
    {
        $this->getCrudFactory()->createOneToManyRelationshipManager()->createRealation($transfer);

        return $transfer;
    }

    private function createManyToManyRelationship(ModelRelationshipTransfer $transfer)
    {
        dd('IN PROGRESS');
    }

    private function getRelationshipTransfer(Request $request): ModelRelationshipTransfer
    {
        return $this->getCrudFactory()->createDtoMapper()->mapModelRelationshipToDto(
                $this->getCrudFactory()->createModelRelationshipTransfer(),
                $request,
            );
    }

    private function saveRelationEntry(ModelRelationshipTransfer $transfer)
    {
        $params = [
            'aim_model' => $transfer->getAimModelName(),
            'ref_model' => $transfer->getRefModelName(),
            'relation_type' => $transfer->getRelationType(),
        ];

        RelatedModel::create($params);
    }

    private function getFullyQualifiedClassName(string $modelName): string
    {
        return sprintf("App\Models\%1\$s\%1\$s", $modelName);
    }
}
