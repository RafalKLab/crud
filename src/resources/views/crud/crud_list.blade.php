@extends('crud::template.default')
@section('content')

    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">table name</th>
                <th scope="col">model name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cruds as $crud)
                <tr>
                    <td>{{ $crud->table_name }}</td>
                    <td>{{ $crud->model_name }}</td>
                    <td><a href="{{route("$crud->route")}}" class="btn btn-light">Show</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cruds->links() }}
    </div>

@endsection
