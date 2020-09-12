@extends('master')

@section('content')
<h2 class="content-heading">Employee List Module</h2>
<a href="{{ action('EmployeeController@create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> New Employee</a>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Employee List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table" style="">
                    <thead>
                        <tr>
                            <th class="text-center">Employee Name</th>
                            <th class="text-center">Email Address</th>
                            <th class="text-center">User Category</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Import Student List</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="fa fa-upload"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'EmployeeController@import','novalidate' => 'novalidate','files' => 'true']) !!}
                    <div class="form-group">
                        <label >Select File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="example-file-input-custom" name="file" data-toggle="custom-file-input">
                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Import</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div> -->
@endsection
@section('js')
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('EmployeeController@index') }}",
        columns: [
            {data: 'lastname', name: 'lastname'},
            {data: 'email', name: 'email'},
            {data: 'category', name: 'category'},
            {data: 'action', name: 'action'},
        ]
    });
    
  });
</script>
@endsection