@extends('crud::template.default')

@section('content')
    <div class="container">
        @isset($student)
            <h1>student update: {{$student->name}}</h1>
        @else
            <h1>Add new student</h1>
        @endisset
        <hr>
        <form method="POST"
              @isset($student)
              action="{{route('students.update', $product)}}"
              @else
              action="{{route('students.store')}}"
            @endisset
        >
            <div>
                @isset($student)
                    @method('PUT')
                @endisset
                @csrf


                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
@endsection
