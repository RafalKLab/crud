@extends('crud::template.default')
@section('content')
    <div class="container">
        <div class="row">
            <form method="POST">
                <div class="form-group">
                    <label for="crudListItems">CRUD list pagination</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Current: {{$crudListPagination}}</span>
                        </div>
                        <input  type="text" name="crud_list_pagination" class="form-control" id="crudListItems" aria-describedby="inputGroupPrepend" placeholder="Enter CRUD list pagination">
                    </div>
                    @if ($errors->has('crud_list_pagination'))
                            <span class="help-block text-danger">
                                {{ $errors->first('crud_list_pagination')}}
                            </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="relationshipListPagination">Relationships list pagination</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Current: {{$relationshipListPagination}}</span>
                        </div>
                        <input  type="text" name="relationships_list_pagination" class="form-control" id="relationshipListPagination" aria-describedby="relationshipListPagination" placeholder="Enter relationship list pagination">
                    </div>
                    @if ($errors->has('relationships_list_pagination'))
                        <span class="help-block text-danger">
                            {{ $errors->first('relationships_list_pagination')}}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="crud_elements_pagination">Generated CRUD items pagination</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Current: {{$crudElementsPagination}}</span>
                        </div>
                        <input  type="text" name="crud_elements_pagination" class="form-control" id="crud_elements_pagination" aria-describedby="crud_elements_pagination" placeholder="Enter generated CRUD elements pagination list">
                    </div>
                    @if ($errors->has('crud_elements_pagination'))
                        <span class="help-block text-danger">
                            {{ $errors->first('crud_elements_pagination')}}
                        </span>
                    @endif
                </div>
                @csrf

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

@endsection
