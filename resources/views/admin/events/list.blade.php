@extends('master')

@section('content')
<h2 class="content-heading">Events Module</h2>
<a href="{{ action('EventController@index') }}" class="btn btn-primary"><i class="fa fa-home"></i> Back to Index</a>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Event Dates of {{ $event->title }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center" width="200">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->eventdates as $e)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($e->event_date)->toFormattedDateString() }}</td>
                                    <td class="text-center">
                                        <a href="{{ action('EventController@print',$e->id) }}" class="btn btn-success"><i class="fa fa-print"></i> Print Attendance</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection