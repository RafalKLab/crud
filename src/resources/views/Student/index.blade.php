@extends('crud::template.default')
@section('content')
    <div class="container">

        <h1>students</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">age</th>
                <th scope="col">action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->age}}</td>
                    <td>
                        <form action="{{route('students.destroy', $student)}}" method="POST">
                            <a href="{{route('students.show', $student)}}" class="btn btn-light">show</a>
                            <a href="{{route('students.edit', $student)}}" class="btn btn-info">edit</a>
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $students->links() }}
        <a href="{{route('students.create')}}" class="btn btn-success">Add new</a>
    </div>

@endsection
