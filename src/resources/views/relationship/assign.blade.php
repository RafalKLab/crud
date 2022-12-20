@extends('crud::template.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Assign/unassign <b>{{$refModel}}</b> to/from <b>{{$aimModel}}</b></h3>
            <hr>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-6 text-center rounded">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    @foreach($refModelFieldNames as $fieldName)
                        <th scope="col">{{$fieldName}}</th>
                    @endforeach
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignedData as $assignedEntity)
                    <tr>
                        <th scope="col">{{$assignedEntity->id}}</th>
                        @foreach($refModelFieldNames as $fieldName)
                            <th scope="col">{{$assignedEntity->$fieldName}}</th>
                        @endforeach
                        <th>
                            <a href="{{route('relationship.unAssign', ['ref_model_name'=>$refModel, 'ref_id'=>$assignedEntity->id, 'aim_model_name'=>$aimModel, 'aim_id'=> $aimModelId])}}" class="btn btn-danger">unassing</a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6 text-center rounded">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    @foreach($refModelFieldNames as $fieldName)
                        <th scope="col">{{$fieldName}}</th>
                    @endforeach
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($unAssignedData as $unAssignedEntity)
                    <tr>
                        <th scope="col">{{$unAssignedEntity->id}}</th>
                        @foreach($refModelFieldNames as $fieldName)
                            <th scope="col">{{$unAssignedEntity->$fieldName}}</th>
                        @endforeach
                        <th>
                            <a href="{{route('relationship.assign', ['ref_model_name'=>$refModel, 'ref_id'=>$unAssignedEntity->id, 'aim_model_name'=>$aimModel, 'aim_id'=> $aimModelId])}}" class="btn btn-primary">assign</a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
