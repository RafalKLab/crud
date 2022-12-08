@extends('crud::template.default')
@section('content')
    <div class="container">
        <h1>Create new student</h1>

        <form method="post" action="{{route('students.store')}}">
            <div class="form-group">
                <label for="age">age</label>
                <input type="text" class="form-control" id="age" name="age" placeholder="Enter age">
            </div>
            @csrf
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection



