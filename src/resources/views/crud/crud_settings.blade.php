@extends('crud::template.default')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @php
                    $number_of_fields = Session::get('number_of_fields')
                @endphp

                <form method="post" action="{{route('generate')}}">
                    <div class="form-group">
                        <label for="table_name">Table name</label>
                        <input type="text" class="form-control" id="table_name" name="table_name"
                               placeholder="Enter table name"
                               value="{{Request::old('table_name') ? : ''}}"
                        >
                        @if ($errors->has('table_name'))
                            <span class="help-block text-danger">
                            {{ $errors->first('table_name')}}
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="model_name">Model name</label>
                        <input type="text" class="form-control" id="model_name" name="model_name"
                               placeholder="Enter model name"
                               value="{{Request::old('table_name') ? : ''}}"
                        >
                        @if ($errors->has('model_name'))
                            <span class="help-block text-danger">
                            {{ $errors->first('model_name')}}
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="fieldItterator" name="fieldItterator" value="{{$number_of_fields}}">
                    </div>
                    @for ($i = 1; $i <= $number_of_fields; $i++)
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="field_name_{{$i}}"
                                       value="{{Request::old("field_name_$i") ? : ''}}"
                                >
                                @if ($errors->has("field_name_$i"))
                                    <span class="help-block text-danger">
                                 {{ $errors->first("field_name_$i")}}
                                  </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" aria-label="select type" name="select_type_{{$i}}">
                                    <option value="{{Request::old("select_type_$i") ? : ''}}" selected>{{Request::old("select_type_$i") ? : '---type---'}}</option>
                                    <option value="int">int</option>
                                    <option value="string">string</option>
                                    <option value="bool">bool</option>
                                </select>
                                @if ($errors->has("select_type_$i"))
                                    <span class="help-block text-danger">
                                 {{ $errors->first("select_type_$i")}}
                                  </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" id="required_{{$i}}"
                                       name="required_{{$i}}"
                                       @if (Request::old("required_$i"))
                                           checked
                                       @endif
                                >
                                <label class="form-check-label" for="required_{{$i}}">
                                    required
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input" type="checkbox" id="unique_{{$i}}"
                                       name="unique_{{$i}}"
                                       @if (Request::old("unique_$i"))
                                       checked
                                    @endif
                                >
                                <label class="form-check-label" for="unique_{{$i}}">
                                    unique
                                </label>
                            </div>
                        </div>
                    @endfor

                    @csrf
                    <button class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>
@endsection
