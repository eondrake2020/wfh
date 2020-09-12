@extends('master')

@section('content')
<h2 class="content-heading">Task Module</h2>
<a href="{{ action('DashboardController@index') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-home"></i> Back to Dashboard</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Task Member List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th class="text-center">Member</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($task->task_members as $tm)
                        <tr>
                            <td>{{ $tm->employee->FullName }}</td>
                            <td>
                                <?php 
                                    $reply = \App\Task_reply::where('task_id',$task->id)
                                        ->where('employee_id',$tm->employee_id)
                                        ->first();

                                    if($reply == NULL){
                                        $status = 'NO REPLY';
                                    }else{
                                        if($reply->isApprove == 1){
                                            $status = 'APPROVED';
                                        }else{
                                            $status = 'PENDING APPROVAL';
                                        }
                                    }
                                ?>
                                {{ $status }}
                            </td>
                            <td class="text-center">
                                <a href="{{ url('dashboard/task-reply/'.$task->id.'/'.$tm->employee_id ) }}" class="btn btn-primary btn-sm">View Reply</a>
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