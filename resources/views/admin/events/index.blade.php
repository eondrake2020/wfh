@extends('master')

@section('content')
<h2 class="content-heading">Events Module</h2>
<a href="{{ action('EventController@create') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Create Event</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Event List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Event Title</th>
                            <th class="text-center">Event Description</th>
                            <th class="text-center">Date From</th>
                            <th class="text-center">Date To</th>
                            <th class="text-center" width="150">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('EventController@index') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'date_from', name: 'date_from'},
            {data: 'date_to', name: 'date_to'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection