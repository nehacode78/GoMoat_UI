@extends('layouts.app')
@section('title', __('essentials::lang.attendance'))

@section('content')
@include('essentials::layouts.nav_hrm')

<!--
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.attendance')
        </h1>
    </section>
    -->

<!-- Main content -->
<section class="content">
    @if (session('notification') || !empty($notification))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @if(!empty($notification['msg']))
                        {{$notification['msg']}}
                    @elseif(session('notification.msg'))
                        {{ session('notification.msg') }}
                    @endif
                </div>
            </div>  
        </div>     
    @endif


{{-- Tabs Section --}}
<div class="attendance-green-tabs no-print">
    <div class="green-tabs-wrapper" style="margin-left: 24px; margin-right: 24px;">
        <ul class="green-tabs-list" style="margin-top: -20px;">

            <li>
                <a href="#attendance_tab"
                   data-toggle="tab"
                   class="green-tab-link active">
                    ATTENDANCE
                </a>
            </li>

            @can('essentials.crud_all_attendance')
            <li>
                <a href="#shifts_tab"
                   data-toggle="tab"
                   class="green-tab-link">
                    SHIFTS
                </a>
            </li>

            <li>
                <a href="#import_attendance_tab"
                   data-toggle="tab"
                   class="green-tab-link">
                    IMPORT
                </a>
            </li>
            @endcan

        </ul>
    </div>
</div>



    <div class="row">
        <div class="col-md-12">


                <div class="tab-content tw-px-4 table-bordered" style="margin-top:20px; background-color:#F7F7F7;">
                    @can('essentials.crud_all_attendance')
                        <div class="tab-pane" id="shifts_tab" style="margin-top:20px;">


                               <!-- Header -->
                               <div class="shift-card-header">

                                   <!-- Left -->
                                   <div class="shift-title">
                                       <i class="fas fa-clock"></i>
                                       <span>Shifts</span>
                                   </div>

                                   <!-- Right -->
                                   <button type="button"
                                       class="shift-add-btn btn-modal"
                                       data-toggle="modal"
                                       data-target="#shift_modal">
                                       <i class="fas fa-plus"></i>
                                       Add shift
                                   </button>

                               </div>

                               <!-- Table -->
                               <div class="table-responsive">
                                   <table class="table table-striped" id="shift_table" style="width:100%;">
                                       <thead>
                                           <tr>
                                               <th>@lang('lang_v1.name')</th>
                                               <th>@lang('essentials::lang.shift_type')</th>
                                               <th>@lang('restaurant.start_time')</th>
                                               <th>@lang('restaurant.end_time')</th>
                                               <th>@lang('essentials::lang.holiday')</th>
                                               <th>@lang('messages.action')</th>
                                           </tr>
                                       </thead>
                                   </table>
                               </div>


                        </div>
                    @endcan
                  <div class="tab-pane active" id="attendance_tab">
                      <div class="row" style="    margin-top: 20px;">


                            @can('essentials.crud_all_attendance')
                                <div class="col-md-3">
                                    <!--
                                    <div class="form-group">
                                                                            {!! Form::label('employee_id', __('essentials::lang.employee') . ':') !!}
                                                                            {!! Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                                                        </div>

                                    -->

                                <div class="attendance-title">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Attendance</span>
                                        </div>

                                </div>
                            @endcan
                            <div class="col-md-3">
                                <!--
                                <div class="form-group">
                                                                    {!! Form::label('date_range', __('report.date_range') . ':') !!}
                                                                    {!! Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                                                                </div>

                                -->

                            </div>
                            @can('essentials.crud_all_attendance')
                            <div class="col-md-6 spacer">
                            <button type="button" class="tw-dw-btn bg-blue
                             tw-from-indigo-600 tw-px-4 tw-py-2  tw-to-blue-500 tw-font-bold tw-text-white
                             tw-border-none tw-rounded-md pull-right btn-modal"
                                data-href="{{action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'create'])}}" data-container="#attendance_modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg> @lang( 'essentials::lang.add_latest_attendance' )
                            </button>
                            </div>
                            @endcan
                        </div>
                        <div id="user_attendance_summary" class="hide">
                            <h3>
                                <strong>@lang('essentials::lang.total_work_hours'):</strong>
                                <span id="total_work_hours"></span>
                            </h3>
                        </div>
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="attendance_table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang( 'lang_v1.date' )</th>
                                        <th>@lang('essentials::lang.employee')</th>
                                        <th>@lang('essentials::lang.clock_in')</th>
                                        <th>@lang('essentials::lang.clock_out')</th>
                                        <th>@lang('essentials::lang.work_duration')</th>
                                        <th>@lang('essentials::lang.ip_address')</th>
                                        <th>@lang('essentials::lang.shift')</th>
                                        @can('essentials.crud_all_attendance')
                                            <th>@lang( 'messages.action' )</th>
                                        @endcan
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="attendance_by_shift_tab">
                        @include('essentials::attendance.attendance_by_shift')
                    </div>
                    <div class="tab-pane" id="attendance_by_date_tab">
                        @include('essentials::attendance.attendance_by_date')
                    </div>
                    @can('essentials.crud_all_attendance')
                        <div class="tab-pane" id="import_attendance_tab">
                            @include('essentials::attendance.import_attendance')
                        </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
    
</section>
<!-- /.content -->
<div class="modal fade" id="attendance_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
<div class="modal fade" id="edit_attendance_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
<div class="modal fade" id="user_shift_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
<div class="modal fade" id="edit_shift_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
<div class="modal fade" id="shift_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    @include('essentials::attendance.shift_modal')
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            attendance_table = $('#attendance_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader: false,

                dom:
                    "<'tw-flex tw-justify-between tw-items-center tw-mb-4'<'tw-flex tw-items-center'l><'tw-flex tw-items-center tw-gap-3'f<'filter-btn'>>>"
                    + "tr"
                    + "<'tw-flex tw-justify-between tw-items-center tw-mt-4'<'tw-text-sm'i><'tw-flex tw-items-center'p>>",

                ajax: {
                    "url": "{{action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'index'])}}",
                    "data": function(d) {
                        if ($('#employee_id').length) {
                            d.employee_id = $('#employee_id').val();
                        }

                        if($('#date_range').val()) {
                            var start = $('#date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                            var end = $('#date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                            d.start_date = start;
                            d.end_date = end;
                        }
                    }
                },

                buttons: [
                    { extend: 'csv', text: 'CSV', className: 'tw-text-blue-600 tw-text-sm' },
                    { extend: 'excel', text: 'XLS', className: 'tw-text-blue-600 tw-text-sm' },
                    { extend: 'pdf', text: 'PDF', className: 'tw-text-blue-600 tw-text-sm' }
                ],

                columns: [
                    { data: 'date', name: 'clock_in_time' },
                    { data: 'user', name: 'user' },
                    { data: 'clock_in', orderable: false, searchable: false},
                    { data: 'clock_out', orderable: false, searchable: false},
                    { data: 'work_duration', orderable: false, searchable: false},
                    { data: 'ip_address'},
                    { data: 'shift_name', name: 'es.name'},
                    @can('essentials.crud_all_attendance')
                        { data: 'action', orderable: false, searchable: false},
                    @endcan
                ],
            });

            let attendanceExportHtml = `
            <div class="tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom: 10px;">
                <div class="tw-flex tw-items-center tw-gap-2">
                    <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                        <i class="fas fa-file-csv tw-text-[11px]"></i>
                    </div>
                    <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                        <i class="fas fa-file-excel tw-text-[11px]"></i>
                    </div>
                </div>

                <span>Export:</span>

                <a href="#" class="tw-text-blue-600 hover:tw-underline">CSV</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline">XLS</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline">PDF</a>
            </div>
            `;

            $('#attendance_table').closest('.dataTables_wrapper').append(attendanceExportHtml);


            $('#date_range').daterangepicker(
                dateRangeSettings,
                function (start, end) {
                    $('#date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                }
            );
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#date_range').val('');
                attendance_table.ajax.reload();
            });

            $(document).on('change', '#employee_id, #date_range', function() {
                attendance_table.ajax.reload();
            });

            $(document).on('submit', 'form#attendance_form', function(e) {
                e.preventDefault();
                if($(this).valid()) {
                    $(this).find('button[type="submit"]').attr('disabled', true);
                    var data = $(this).serialize();
                    $.ajax({
                        method: $(this).attr('method'),
                        url: $(this).attr('action'),
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                $('div#attendance_modal').modal('hide');
                                $('div#edit_attendance_modal').modal('hide');
                                toastr.success(result.msg);
                                attendance_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });

            $(document).on( 'change', '#employee_id, #date_range', function() {
                get_attendance_summary();
            });

            @if(!auth()->user()->can('essentials.crud_all_attendance'))
                get_attendance_summary();
            @endif

            shift_table = $('#shift_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader: false,

                dom:
                    "<'tw-flex tw-justify-between tw-items-center tw-mb-4'<'tw-flex tw-items-center'l><'tw-flex tw-items-center tw-gap-3'f<'filter-btn'>>>"
                    + "tr"
                    + "<'tw-flex tw-justify-between tw-items-center tw-mt-4'<'tw-text-sm'i><'tw-flex tw-items-center'p>>",

                ajax: {
                    "url": "{{action([\Modules\Essentials\Http\Controllers\ShiftController::class, 'index'])}}",
                },

                buttons: [
                    { extend: 'csv', text: 'CSV', className: 'tw-text-blue-600 tw-text-sm' },
                    { extend: 'excel', text: 'XLS', className: 'tw-text-blue-600 tw-text-sm' },
                    { extend: 'pdf', text: 'PDF', className: 'tw-text-blue-600 tw-text-sm' }
                ],

                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'start_time', name: 'start_time' },
                    { data: 'end_time', name: 'end_time' },
                    { data: 'holidays', name: 'holidays' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });


            let shiftExportHtml = `
            <div class="tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom: 10px;">
                <div class="tw-flex tw-items-center tw-gap-2">
                    <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                        <i class="fas fa-file-csv tw-text-[11px]"></i>
                    </div>
                    <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                        <i class="fas fa-file-excel tw-text-[11px]"></i>
                    </div>
                </div>

                <span>Export:</span>

                <a href="#" class="tw-text-blue-600 hover:tw-underline shift-export-csv">CSV</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline shift-export-xls">XLS</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline shift-export-pdf">PDF</a>
            </div>
            `;

            $('#shift_table').closest('.dataTables_wrapper').append(shiftExportHtml);


            // Trigger shift exports
            $(document).on('click', '.shift-export-csv', function(e) {
                e.preventDefault();
                shift_table.button('.buttons-csv').trigger();
            });

            $(document).on('click', '.shift-export-xls', function(e) {
                e.preventDefault();
                shift_table.button('.buttons-excel').trigger();
            });

            $(document).on('click', '.shift-export-pdf', function(e) {
                e.preventDefault();
                shift_table.button('.buttons-pdf').trigger();
            });

            $('#shift_modal, #edit_shift_modal').on('shown.bs.modal', function(e) {
                $('form#add_shift_form').validate();
                $('#shift_modal #start_time, #shift_modal #end_time, #edit_shift_modal #start_time, #edit_shift_modal #end_time').datetimepicker({
                    format: moment_time_format,
                    ignoreReadonly: true,
                });
                $('#shift_modal .select2, #edit_shift_modal .select2').select2();

                if ($('select#shift_type').val() == 'fixed_shift') {
                    $('div.time_div').show();
                } else if ($('select#shift_type').val() == 'flexible_shift') {
                    $('div.time_div').hide();
                }

                $('select#shift_type').change(function() {
                    var shift_type = $(this).val();
                    if (shift_type == 'fixed_shift') {
                        $('div.time_div').fadeIn();
                    } else if (shift_type == 'flexible_shift') {
                        $('div.time_div').fadeOut();
                    }
                });

                //toggle auto clockout
                if($('#is_allowed_auto_clockout').is(':checked')) {
                    $("div.enable_auto_clock_out_time").show();
                } else {
                    $("div.enable_auto_clock_out_time").hide(); 
                }

                $('#is_allowed_auto_clockout').on('change', function(){
                    if ($(this).is(':checked')) {
                        $("div.enable_auto_clock_out_time").show();
                    } else {
                       $("div.enable_auto_clock_out_time").hide(); 
                    }
                });
                
                $('#shift_modal #auto_clockout_time, #edit_shift_modal #auto_clockout_time').datetimepicker({
                    format: moment_time_format,
                    stepping: 30,
                    ignoreReadonly: true,
                });
            });
            $('#shift_modal, #edit_shift_modal').on('hidden.bs.modal', function(e) {
                $('#shift_modal #start_time').data("DateTimePicker").destroy();
                $('#shift_modal #end_time').data("DateTimePicker").destroy();
                $('#add_shift_form')[0].reset();
                $('#add_shift_form').find('button[type="submit"]').attr('disabled', false);

                $('#is_allowed_auto_clockout').attr('checked', false);
                $('#auto_clockout_time').data("DateTimePicker").destroy();
                $("div.enable_auto_clock_out_time").hide(); 
            });
            $('#user_shift_modal').on('shown.bs.modal', function(e) {
                $('#user_shift_modal').find('.date_picker').each( function(){
                    $(this).datetimepicker({
                        format: moment_date_format,
                        ignoreReadonly: true,
                    });
                });
            });

            @can('essentials.crud_all_attendance')
                get_attendance_by_shift();
                $('#attendance_by_shift_date_filter').datetimepicker({
                    format: moment_date_format,
                    ignoreReadonly: true,
                });
                var attendanceDateRangeSettings = dateRangeSettings;
                attendanceDateRangeSettings.startDate = moment().subtract(6, 'days');
                attendanceDateRangeSettings.endDate = moment();
                $('#attendance_by_date_filter').daterangepicker(
                    dateRangeSettings,
                    function (start, end) {
                        $('#attendance_by_date_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                    }
                );
                get_attendance_by_date();
                $(document).on('change', '#attendance_by_date_filter', function(){
                    get_attendance_by_date();
                });
            @endcan

            $('a[href="#attendance_tab"]').click(function(){
                attendance_table.ajax.reload();
            });
            $('a[href="#attendance_by_shift_tab"]').click(function(){
                get_attendance_by_shift();
            });
            $('a[href="#attendance_by_date_tab"]').click(function(){
                get_attendance_by_date();
            });
        });

        $(document).on('click', 'button.delete-attendance', function() {
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                attendance_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
        $('#edit_attendance_modal').on('hidden.bs.modal', function(e) {
            $('#edit_attendance_modal #clock_in_time').data("DateTimePicker").destroy();
            $('#edit_attendance_modal #clock_out_time').data("DateTimePicker").destroy();
        });

        $('#attendance_modal').on('shown.bs.modal', function(e) {
            $('#attendance_modal .select2').select2();
        });
        $('#edit_attendance_modal').on('shown.bs.modal', function(e) {
            $('#edit_attendance_modal .select2').select2();
            $('#edit_attendance_modal #clock_in_time, #edit_attendance_modal #clock_out_time').datetimepicker({
                format: moment_date_format + ' ' + moment_time_format,
                ignoreReadonly: true,
            });

            validate_clockin_clock_out = {
                url: '/hrm/validate-clock-in-clock-out',
                type: 'post',
                data: {
                    user_ids: function() {
                        return $('#employees').val();
                    },
                    clock_in_time: function() {
                        return $('#clock_in_time').val();
                    },
                    clock_out_time: function() {
                        return $('#clock_out_time').val();
                    },
                    attendance_id: function() {
                        if($('form#attendance_form #attendance_id').length) {
                           return $('form#attendance_form #attendance_id').val();
                        } else {
                            return '';
                        }
                    },
                },
            };

            $('form#attendance_form').validate({
                rules: {
                    clock_in_time: {
                        remote: validate_clockin_clock_out,
                    },
                    clock_out_time: {
                        remote: validate_clockin_clock_out,
                    },
                },
                messages: {
                    clock_in_time: {
                        remote: "{{__('essentials::lang.clock_in_clock_out_validation_msg')}}",
                    },
                    clock_out_time: {
                        remote: "{{__('essentials::lang.clock_in_clock_out_validation_msg')}}",
                    },
                },
            });
        });



        function get_attendance_summary() {
            $('#user_attendance_summary').addClass('hide');
            var user_id = $('#employee_id').length ? $('#employee_id').val() : '';
            
            var start = $('#date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end = $('#date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            $.ajax({
                url: '{{action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'getUserAttendanceSummary'])}}?user_id=' + user_id + '&start_date=' + start + '&end_date=' + end ,
                dataType: 'html',
                success: function(response) {
                    $('#total_work_hours').html(response);
                    $('#user_attendance_summary').removeClass('hide');
                },
            });
        }

    //Set mindate for clockout time greater than clockin time
    $('#attendance_modal').on('dp.change', '#clock_in_time', function(){
        if ($('#clock_out_time').data("DateTimePicker")) {
            $('#clock_out_time').data("DateTimePicker").options({minDate: $(this).data("DateTimePicker").date()});
            $('#clock_out_time').data("DateTimePicker").clear();
        }
    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.green-tab-link').removeClass('active');
        $(e.target).addClass('active');
    });

    $(document).on('submit', 'form#add_shift_form', function(e) {
        e.preventDefault();
        $(this).find('button[type="submit"]').attr('disabled', true);
        var data = $(this).serialize();

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.success == true) {
                    if ($('div#edit_shift_modal').hasClass('in')) {
                        $('div#edit_shift_modal').modal("hide");
                    } else if ($('div#shift_modal').hasClass('in')) {
                        $('div#shift_modal').modal('hide');    
                    }
                    toastr.success(result.msg);
                    shift_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });

    $(document).on('submit', 'form#add_user_shift_form', function(e) {
        e.preventDefault();
        $(this).find('button[type="submit"]').attr('disabled', true);
        var data = $(this).serialize();

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.success == true) {
                    $('div#user_shift_modal').modal('hide');
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                }
                $('form#add_user_shift_form').find('button[type="submit"]').attr('disabled', false);
            },
        });
    });

    function get_attendance_by_shift() {
        data = {date: $('#attendance_by_shift_date_filter').val()};
        $.ajax({
            url: "{{action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'getAttendanceByShift'])}}",
            data: data,
            dataType: 'html',
            success: function(result) {
                $('table#attendance_by_shift_table tbody').html(result);
            },
        });
    }
    function get_attendance_by_date() {
        data = {
                start_date: $('#attendance_by_date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD'),
                end_date: $('#attendance_by_date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD')
            };
        $.ajax({
            url: "{{action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'getAttendanceByDate'])}}",
            data: data,
            dataType: 'html',
            success: function(result) {
                $('table#attendance_by_date_table tbody').html(result);
            },
        });
    }
    $(document).on('dp.change', '#attendance_by_shift_date_filter', function(){
        get_attendance_by_shift();
    });
    $(document).on('change', '#select_employee', function(e) {
        var user_id = $(this).val();
        var count = 0;
        $('table#employee_attendance_table tbody').find('tr').each( function(){
            if ($(this).data('user_id') == user_id) {
                count++;
            }
        });
        
        if (user_id && count == 0) {
            $.ajax({
                url: "/hrm/get-attendance-row/" + user_id,
                dataType: 'html',
                success: function(result) {
                    $('table#employee_attendance_table tbody').append(result);
                    var tr = $('table#employee_attendance_table tbody tr:last');

                    tr.find('.date_time_picker').each( function(){
                        $(this).datetimepicker({
                            format: moment_date_format + ' ' + moment_time_format,
                            ignoreReadonly: true,
                            maxDate: moment(),
                            widgetPositioning: {
                                horizontal: 'auto',
                                vertical: 'bottom'
                             }
                        });
                        $(this).val('');
                    });
                    $('#select_employee').val('').change();
                },
            });
        }
    });
    $(document).on('click', 'button.remove_attendance_row', function(e) {
        $(this).closest('tr').remove();
    });

</script>
@endsection

@section('css')
<style>

.green-tab-link {
    position: relative;
    padding: 14px 0;
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.3s ease;
}

.green-tab-link:hover {
    color: #15803d;
}

.green-tab-link.active {
    color: #166534;
}

.green-tab-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: #166534;
    border-radius: 2px;
}





<style>

/* Move tabs slightly upward */
.attendance-green-tabs {
    margin-left: 24px;
    margin-right: 24px;
    margin-top: 10px;   /* ↓ Reduced from 28px */
    margin-bottom: 18px;
}

/* Thin bottom border */
.green-tabs-wrapper {
    border-bottom: 1px solid #e5e7eb;
}

/* Horizontal spacing between tabs */
.green-tabs-list {
    display: flex;
    gap: 56px; /* more like Figma */
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Tab text styling */
.green-tab-link {
    position: relative;
    display: inline-block;
    padding: 12px 0 14px 0; /* tighter top padding */
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.2s ease;
}

/* Hover */
.green-tab-link:hover {
    color: #15803d;
}

/* Active tab text */
.green-tab-link.active {
    color: #166534;
}

/* Active underline */
.green-tab-link.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: #166534;
    border-radius: 2px;
}




.dataTables_wrapper .dataTables_length select {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 4px 8px;
}

.dataTables_wrapper .dataTables_filter input {
    border: none;
    border-bottom: 1px solid #d1d5db;
    outline: none;
    padding: 4px 8px;
    font-size: 13px;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-bottom: 1px solid #166534;
}



/* Remove default datatable styling */
.dataTables_filter label {
    position: relative;
    margin: 0;
    width: 220px;
}

.dataTables_filter input {
    width: 100% !important;
    height: 34px !important;
    border: none !important;
    border-bottom: 1px solid #d1d5db !important;
    border-radius: 0 !important;
    background: transparent !important;
    padding: 0 24px 4px 0 !important;
    font-size: 13px !important;
    color: #374151 !important;
    box-shadow: none !important;
}

/* Remove focus glow */
.dataTables_filter input:focus {
    outline: none !important;
    border-bottom: 1px solid #9ca3af !important;
}

/* Placeholder style */
.dataTables_filter input::placeholder {
    color: #9ca3af;
    font-size: 13px;
}

/* Search icon */
.dataTables_filter label::after {
    content: "\f002";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    right: 0;
    bottom: 8px;
    font-size: 12px;
    color: #9ca3af;
}


/* ===== Card Container ===== */
.attendance-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

/* ===== Header Flex Alignment ===== */
.attendance-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

/* ===== Title Styling ===== */
.attendance-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 16px;
    color: #1f2937;
    margin-top: 26px;
}

/* ===== Button Styling ===== */
.add-attendance-btn {
    background: #2B7ADA;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    font-size: 14px;
    font-weight: 500;
    transition: 0.2s ease;
}

.add-attendance-btn:hover {
    background: #1f5bd8;
}

/* ===== SHIFT CARD ===== */
.shift-card {
    background: #ffffff;
/*     border-radius: 10px; */
    padding: 20px;
    border: 1px solid #e5e7eb;
/*     box-shadow: 0 1px 2px rgba(0,0,0,0.04); */
}

/* ===== HEADER ALIGNMENT ===== */
.shift-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

/* ===== TITLE ===== */
.shift-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 16px;
    color: #1f2937;
}

/* ===== BUTTON ===== */
.shift-add-btn {
    background: #2B7ADA;
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: 0.2s ease;
}

.shift-add-btn:hover {
    background: #1f5bd8;
}
</style>
@endsection



