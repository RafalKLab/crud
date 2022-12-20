@extends('crud::template.default')

@section('content')
    <div class="container">
        <h2>Create model relationship</h2>
        <hr>
        <form method="POST">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="aim_model">Aim model</label>
                        <select class="" id="aim_model" name="aim_model">
                            <option value="" selected>---select model---</option>
                            @foreach($cruds as $crud)
                                <option value="{{$crud->id}}">{{ $crud->model_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="relationship_type">relationship type</label>
                        <select class="" id="relationship_type" name="relationship_type">
                            <option value="1:N">One-to-many (1:N)</option>
                            <option value="N:N" disabled>Many-to-many (N:N)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ref_model">Reference model</label>
                        <select class="" id="ref_model" name="ref_model">
                            <option value="" selected>---select model---</option>
                            @foreach($cruds as $crud)
                                <option value="{{$crud->id}}">{{ $crud->model_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @csrf

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
