@extends('crud::template.default')
@section('content')
    <div class="container">

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">age</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$student->id}}</td>
                <td>{{$student->age}}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{route('students.index')}}">Back</a>
    </div>

@endsection


