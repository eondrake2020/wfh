@extends('master')

@section('content')
<h2 class="content-heading">Dashboard of <span style="text-transform: uppercase; font-weight: bolder;color: blue;">{{ $employee->FullName }}</span></h2>
<p>
    <b>Work From Home Schedule:
    @if($employee->schedule->count() > 0)
    @foreach($employee->schedule as $ec)
    <span class="badge badge-primary">{{ $ec->weekday->name }}</span> 
    @endforeach
    @endif</b>
    
</p>
<center>
	<h1>{{ \Carbon\Carbon::now()->toFormattedDateString() }}</h1>
	<h5 id="txt"></h5>
	<a href="{{ action('DashboardController@login') }}" class="btn btn-success"><i class="fa fa-sign-in"></i> Login</a>
	<a href="{{ action('DashboardController@logout') }}" class="btn btn-primary"><i class="fa fa-sign-out"></i> Logout</a>
    <div style="margin-top: 20px;"></div>
    <?php 
        $dtr = \App\Employee_login::where('employee_id',Auth::user()->employee_id)
            ->where('date',\Carbon\Carbon::now()->toDateString())
            ->first();
    ?>
    @if($dtr != NULL)
    <table class="table table-bordered" style="text-transform: uppercase;">
        <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Login Time</th>
                <th class="text-center">Logout Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($dtr->date)->toFormattedDateString() }}</td>
                <td class="text-center">
                    {{ date("g:i A", strtotime(\Carbon\Carbon::parse($dtr->login)->toTimeString())) }}
                </td>
                <td class="text-center">
                    @if($dtr->logout == NULL)
                    -
                    @else
                    {{ date("g:i A", strtotime(\Carbon\Carbon::parse($dtr->logout)->toTimeString())) }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @endif
</center>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Group Task List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Task Type</th>
                            <th class="text-center">Task Deadline</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@if($employee->category == 'ADMIN')
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-success">
                <h3 class="block-title">Individual Task List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Task Type</th>
                            <th class="text-center">Task Deadline</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center" width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admintasks as $a)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($a->date)->toFormattedDateString() }}</td>
                            <td>{{ $a->task_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($a->date_started)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($a->date_ended)->toFormattedDateString() }}</td>
                            <td>{{ $a->admin->FullName }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a href="{{ action('DashboardController@view_task',$a->id) }}" class="dropdown-item"> View Task</a>
                                        <a href="{{ action('DashboardController@view_task_replies',$a->id) }}" class="dropdown-item"> View Replies</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('modal')
@if($employee->schedule->count() == 0)
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-onboarding" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-popout" role="document">
        <div class="modal-content rounded">
            <div class="block block-rounded block-transparent mb-0 bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
                <div class="block-header justify-content-end">
                    <div class="block-options">
                        <a class="font-w600 text-danger" href="#" data-dismiss="modal" aria-label="Close">
                            Close this form
                        </a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="js-slider slick-dotted-inner" data-dots="true" data-arrows="false" data-infinite="false">
                        <div class="pb-50">
                            <div class="row justify-content-center text-center">
                                <div class="col-md-10 col-lg-8">
                                    <i class="fa fa-university fa-4x text-primary"></i>
                                    <h3 class="font-size-h2 font-w300 mt-20">Welcome to HCCD - WFH</h3>
                                    <p class="text-center">
                                        In order your attendance will be officially counted on the attendance report, kindly indicate your WFH Schedule by clicking the upper right corner menu, click Create Schedule, then select your schedule days and save it. Thanks and God bless!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('js')
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('DashboardController@index') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'task_type', name: 'task_type'},
            {data: 'dates', name: 'dates'},
            {data: 'created', name: 'created'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection