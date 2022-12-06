@extends('crud::template.default')
@section('content')

        <form method="post" action="{{route("entity")}}">
            <div class="form-group">
                <label for="exampleInputEmail1">Entity name</label>
                <input type="text" class="form-control" name="entity" id="entitty" placeholder="Enter name">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            @csrf
        </form>

@endsection
