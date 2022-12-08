@extends('crud::template.default')
@section('content')

    <div class="container">
        <h1>Edit </h1>

        <form method="POST" action="{{route('students.update', $student)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="age">age</label>
                <input type="text" class="form-control" id="age" name="age" placeholder="Enter age"
                       value="{{$student->age}}">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>

@endsection

