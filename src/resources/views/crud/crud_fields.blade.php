@extends('crud::template.default')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form method="post">
                    <div class="form-group">
                        <label for="table_name">Number of fields</label>
                        <br>
                        <small>* Id, foreign key and time of creation and updating fields are being added automatically</small>
                        <hr>
                        <input type="text" class="form-control" id="number_of_fields" name="number_of_fields"
                               placeholder="How many table fields needs to be generated ?">
                        @if ($errors->has('number_of_fields'))
                            <span class="help-block text-danger">
                            {{ $errors->first('number_of_fields')}}
                        </span>
                        @endif
                    </div>

                    @csrf
                    <button class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>

@endsection
