@extends('crud::template.default')
@section('content')
    migration step
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Table name</label>
                        <input type="text" class="form-control" id="tableName" name="tableName" placeholder="Enter table name">
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="fieldItterator" name="fieldItterator" value="0">
                        <button type="button" class="btn-success" onclick="addField()">Add field</button>
                    </div>
                    <div class="form-group" id="dynamicallyFields">
{{--                        <div class="row mb-2">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <input type="text" class="form-control" name="field1">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-1">--}}
{{--                                <select class="form-select" aria-label="Default select example">--}}
{{--                                    <option selected>---select---</option>--}}
{{--                                    <option value="int">integer</option>--}}
{{--                                    <option value="string">string</option>--}}
{{--                                    <option value="bool">bool</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}


                    </div>

                    @csrf
                    <button class="btn btn-primary">Next</button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function addField() {
            var number = document.getElementById('fieldItterator');
            number.value = Number(number.value) + 1;
            var fieldContainer = document.getElementById('dynamicallyFields');
            fieldContainer.innerHTML += '<div class="row mb-2"><div class="col-md-4"><input type="text" class="form-control" name="field_' +number.value + '"></div><div class="col-md-1"><select class="form-select" name="select_'+number.value+'"><option selected>---select---</option><option value="int">integer</option><option value="string">string</option><option value="bool">bool</option></select></div></div>';
        }
    </script>

@endsection
