@extends('crud::template.default')

@section('content')
    <div class="container">
        <h2>Described relationships</h2>
        <hr>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Model</th>
                <th scope="col">Related to</th>
                <th scope="col">By relation</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($relatedModels as $model)
                <tr>
                    <td>{{ $model->aim_model }}</td>
                    <td>{{ $model->ref_model }}</td>
                    <td>{{ $model->relation_type }}</td>
                    <td><a href="{{route('relationship.show', $model)}}" class="btn btn-primary">Show</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $relatedModels->links() }}
    </div>
@endsection
