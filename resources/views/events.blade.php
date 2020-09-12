@extends('master')

@section('content')
<h2 class="content-heading">Dashboard of <span style="text-transform: uppercase; font-weight: bolder;color: blue;">{{ $employee->FullName }}</span></h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Event List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Event Title</th>
                            <th class="text-center">Event Description</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $e)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($e->event_date)->toFormattedDateString() }}</td>
                            <td>{{ $e->event->title }}</td>
                            <td>{{ $e->event->description }}</td>
                            <td class="text-center">
                                <a href="{{ action('DashboardController@attend_event',$e->id) }}" class="btn btn-primary"><i class="fa fa-sign-in"></i> Login</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection