<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Rklab\Crud\dto\ModelRelationshipTransfer;
use Rklab\Crud\Models\RelatedModel;

class ModelRelationshipController extends Controller
{
    public function createRelationship()
    {
        $cruds = $this->getCrudRepository()->getCruds();

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

        return redirect()->route('dashboard');
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
}
