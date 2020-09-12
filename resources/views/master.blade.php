<!DOCTYPE html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>HCCD - WFH</title>

        <link rel="shortcut icon" href="<?php echo asset('public/assets/media/favicons/favicon.png') ?>">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo asset('public/assets/media/favicons/favicon-192x192.png') ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('public/assets/media/favicons/apple-touch-icon-180x180.png') ?>">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" href="<?php echo asset('public/assets/js/plugins/datatables/dataTables.bootstrap4.css') ?>">
        <link rel="stylesheet" href="<?php echo asset('public/assets/js/plugins/select2/css/select2.min.css') ?>">
        <link rel="stylesheet" href="<?php echo asset('public/assets/js/plugins/flatpickr/flatpickr.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link rel="stylesheet" id="css-main" href="<?php echo asset('public/assets/css/codebase.min.css') ?>">
        @toastr_css
    </head>
    <body onload="startTime()">
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
            <nav id="sidebar">
                <div class="sidebar-content">
                    <div class="content-header content-header-fullrow px-15">
                        
                        <div class="content-header-section sidebar-mini-visible-b">
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">HCCD </span><span class="text-primary">WFH</span>
                            </span>
                        </div>
                        
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="#">
                                    <span class="font-size-xl text-dual-primary-dark">HCCD </span><span class="font-size-xl text-primary">WFH</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $employee = \App\Employee::where('id',Auth::user()->employee_id)->first(); ?>
                    <div class="content-side content-side-full content-side-user px-10 align-parent">
                        <div class="sidebar-mini-visible-b align-v animated fadeIn">
                            <img class="img-avatar img-avatar32" src="<?php echo asset('public/images/'.$employee->image) ?>" alt="">
                        </div>
                        <div class="sidebar-mini-hidden-b text-center">
                            <a class="img-link" href="#">
                                @if($employee->image != NULL)
                                <img class="img-avatar" src="<?php echo asset('public/images/'.$employee->image) ?>" alt="">
                                @else
                                @if($employee->gender == 0)
                                <img class="img-avatar" src="<?php echo asset('public/images/male.png') ?>" alt="">
                                @else
                                <img class="img-avatar" src="<?php echo asset('public/images/female.png') ?>" alt="">
                                @endif
                                @endif
                            </a>
                            <ul class="list-inline mt-10">
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="#">
                                        {{ $employee->FullName }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-side content-side-full">
                        
                        <ul class="nav-main">
                            <li>
                                <a href="{{ action('DashboardController@index') }}"><i class="fa fa-home"></i><span class="sidebar-mini-hide"> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('DashboardController@edit_profile',Auth::user()->employee_id) }}"><i class="fa fa-user"></i><span class="sidebar-mini-hide"> Profile
                                </a>
                            </li>
                            @can('isAdmin')
                            <li>
                                <a href="{{ action('DashboardController@view_dtr_requests',Auth::user()->employee_id) }}"><i class="fa fa-reply"></i><span class="sidebar-mini-hide"> DTR Request Lists
                                </a>
                            </li>
                            @endcan
                            <li>
                                <a href="{{ action('DashboardController@dtr_request',Auth::user()->employee_id) }}"><i class="fa fa-clock-o"></i><span class="sidebar-mini-hide"> DTR Request
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('DashboardController@show_events') }}"><i class="fa fa-calendar"></i><span class="sidebar-mini-hide"> Events</span>
                                    <?php 
                                        $taskdate = \App\Event_date::whereDate('event_date','=',\Carbon\Carbon::now()->toDateString())->first();
                                    ?>
                                    @if($taskdate != NULL)
                                    <span class="badge badge-primary">New</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('DashboardController@view_violations',Auth::user()->employee_id) }}"><i class="fa fa-ticket"></i><span class="sidebar-mini-hide"> Violations</span>
                                    <?php 
                                        $checkViolation = \App\Employee_corrective::where('employee_id',Auth::user()->employee_id)->where('explanation',NULL)->first();
                                    ?>
                                    @if($checkViolation != NULL)
                                    <span class="badge badge-primary">New</span>
                                    @endif
                                </a>
                            </li>
                            @can('isAdmin')
                            <li>
                                <a href="{{ action('EmployeecorrectiveController@index') }}"><i class="fa fa-list"></i><span class="sidebar-mini-hide"> Memo</span>
                                    <?php 
                                        $checkViolation = \App\Employee_corrective::where('admin_id',Auth::user()->employee_id)->where('action_taken',NULL)->first();
                                    ?>
                                    @if($checkViolation != NULL)
                                    <span class="badge badge-primary">New</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-cogs"></i><span class="sidebar-mini-hide"> Forms</span></a>
                                <ul>
                                    <li>
                                        <a href="{{ action('CorrectivelevelController@index') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Corrective Levels</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ action('EmployeeController@index') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Employees</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ action('GroupController@index') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Employee Groups</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ action('EventController@index') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Events</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ action('TaskController@index') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Tasks</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-print"></i><span class="sidebar-mini-hide"> Reports</span></a>
                                <ul>
                                    <li>
                                        <a href="{{ action('ReportController@view_attendance_report') }}" data-toggle="#" class="#"><span class="sidebar-mini-hide"> Attendance</span></a>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </nav>

            <header id="page-header">
                <div class="content-header">
                    <div class="content-header-section">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                    </div>
                    <div class="content-header-section">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ $employee->FullName }}</span>
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                                <a class="dropdown-item" href="{{ action('ChangepasswordController@change_password',Auth::user()->employee_id) }}">
                                    <i class="si si-note mr-5"></i> Change Password
                                </a>
                                <?php 
                                    $employee = \App\Employee::find(Auth::user()->employee_id);
                                ?>
                                @if($employee->schedule->count() == 0)
                                <a class="dropdown-item" href="{{ action('DashboardController@view_schedule',Auth::user()->employee_id) }}">
                                    <i class="si si-calendar mr-5"></i> Create Schedule
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('gawas') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="si si-logout mr-5"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('gawas') }}" method="GET" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <main id="main-container">
                
                <div class="content">
                    @yield('content')
                    @yield('modal')
                </div>

            </main>
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Developed by: <a class="font-w600" href="#" target="_blank">MDS</a>
                    </div>
                </div>
            </footer>
        </div>

        <script src="<?php echo asset('public/assets/js/codebase.core.min.js') ?>"></script>
        <script src="<?php echo asset('public/assets/js/codebase.app.min.js') ?>"></script>
        <!-- Page JS Plugins -->
        <script src="<?php echo asset('public/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo asset('public/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script>
        <script src="<?php echo asset('public/assets/js/plugins/select2/js/select2.full.min.js') ?>"></script>
        <script src="<?php echo asset('public/assets/js/plugins/flatpickr/flatpickr.min.js') ?>"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        
        <!-- Page JS Code -->
        <script src="<?php echo asset('public/assets/js/pages/be_tables_datatables.min.js') ?>"></script>
        <script src="<?php echo asset('public/assets/js/pages/be_forms_plugins.min.js') ?>"></script>
        <script>
            $(document).ready(function(){
                $('#table1').DataTable();
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            });
        </script>
        <script>
            function startTime() {
              var today = new Date();
              var h = today.getHours();
              var m = today.getMinutes();
              var s = today.getSeconds();
              m = checkTime(m);
              s = checkTime(s);
              document.getElementById('txt').innerHTML =
              h + ":" + m + ":" + s;
              var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }
        </script>
        <script>jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs','summernote']); });</script>
        @yield('js')
        @toastr_js
        @toastr_render
        @stack('scripts')
    </body>
</html>