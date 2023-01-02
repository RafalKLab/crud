<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Models\RelatedModel;

class ModelRelationshipController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $itemsPerPage = $this->getItemsPerPage();

        $relatedModels = RelatedModel::paginate($itemsPerPage);

        return view("crud::relationship.index")->with('relatedModels', $relatedModels);
    }

    /**
     * @param RelatedModel $model
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|RedirectResponse
     */
    public function show(RelatedModel $model): View | RedirectResponse
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

    /**
     * @param Request $request
     *
     * @return View|RedirectResponse
     */
    public function getAssignTable(Request $request): View | RedirectResponse
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

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function assign(Request $request): RedirectResponse
    {
        $fullyQualifiedRefClassName = $this->getFullyQualifiedClassName($request->ref_model_name);
        $aimModelField = sprintf("%s_id", strtolower($request->aim_model_name));
        $refModelId = $request->ref_id;
        $aimModelId = $request->aim_id;

        $fullyQualifiedRefClassName::where('id', $refModelId)->update([$aimModelField => $aimModelId]);

        return Redirect::back()->with('success',"Model object was assigned.");
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function unAssign(Request $request): RedirectResponse
    {
        $fullyQualifiedRefClassName = $this->getFullyQualifiedClassName($request->ref_model_name);
        $aimModelField = sprintf("%s_id", strtolower($request->aim_model_name));
        $refModelId = $request->ref_id;
        $aimModelId = $request->aim_id;

        $fullyQualifiedRefClassName::where('id', $refModelId)->where($aimModelField, $aimModelId)
            ->update([$aimModelField => null]);

        return Redirect::back()->with('success',"Model object was unassigned.");
    }

    /**
     * @return View
     */
    public function createRelationship(): View
    {
        $cruds = $this->getRepository()->getCruds();

        return view("crud::relationship.form")->with('cruds', $cruds);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function storeRelationship(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'aim_model' => 'required',
            'relationship_type' => 'required',
            'ref_model' => 'required|different:aim_model',
        ]);

        $transfer = $this->getRelationshipTransfer($request);

        match ($request->input('relationship_type')) {
            '1:N' => $this->createOneToManyRelationship($transfer),
        };

        Artisan::call('migrate');

        $this->saveRelationEntry($transfer);

        return redirect()->route('dashboard')->with('success', 'New relation was created!');
    }

    /**
     * @param ModelRelationshipTransfer $transfer
     *
     * @return ModelRelationshipTransfer
     */
    private function createOneToManyRelationship(ModelRelationshipTransfer $transfer): ModelRelationshipTransfer
    {
        $this->getCrudFactory()->createOneToManyRelationshipManager()->createRealation($transfer);

        return $transfer;
    }

    /**
     * @param Request $request
     *
     * @return ModelRelationshipTransfer
     */
    private function getRelationshipTransfer(Request $request): ModelRelationshipTransfer
    {
        return $this->getCrudFactory()->createDtoMapper()->mapModelRelationshipToDto(
                $this->getCrudFactory()->createModelRelationshipTransfer(),
                $request,
            );
    }

    /**
     * @param ModelRelationshipTransfer $transfer
     */
    private function saveRelationEntry(ModelRelationshipTransfer $transfer): void
    {
        $params = [
            'aim_model' => $transfer->getAimModelName(),
            'ref_model' => $transfer->getRefModelName(),
            'relation_type' => $transfer->getRelationType(),
        ];

        RelatedModel::create($params);
    }

    /**
     * @param string $modelName
     *
     * @return string
     */
    private function getFullyQualifiedClassName(string $modelName): string
    {
        return sprintf("App\Models\%1\$s\%1\$s", $modelName);
    }

    private function getItemsPerPage(): int
    {
        return $this->getCrudFactory()->createCrudConfig()->getRelationshipListPaginaton();
    }
}
