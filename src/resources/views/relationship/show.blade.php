@extends('crud::template.default')

@section('content')
    <div class="container">
        <h3><b>{{$model->aim_model}}</b> model entities</h3>
        <hr>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                @foreach($modelDataFieldNames as $fieldName)
                    <th scope="col">{{$fieldName}}:</th>
                @endforeach()
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($modelData as $entity)
                <tr>
                    <th scope="col">{{$entity->id}}</th>
                    @foreach($modelDataFieldNames as $fieldName)
                        <th scope="col">{{$entity->$fieldName}}</th>
                    @endforeach()
                    <td><a href="{{route('relationship.assign.table', ['ref_model_name'=>$model->ref_model, 'aim_model_name' => $model->aim_model, 'id'=>$entity->id ])}}" class="btn btn-primary">Assign {{$model->ref_model}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
