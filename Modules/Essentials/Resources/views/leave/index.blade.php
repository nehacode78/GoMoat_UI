@extends('layouts.app')
@section('title', __('essentials::lang.leave'))

@section('content')
@include('essentials::layouts.nav_hrm')
<!-- <section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.leave')
    </h1>
</section> -->
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
        @component('components.filters', ['title' => __('report.filters'), 'class' => 'box-solid'])
            @if(!empty($users))
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('user_id_filter', __('essentials::lang.employee') . ':') !!}
                    {!! Form::select('user_id_filter', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                </div>
            </div>
            @endif
            <div class="col-md-3">
                <div class="form-group">
                    <label for="status_filter">@lang( 'sale.status' ):</label>
                    <select class="form-control select2" name="status_filter" required id="status_filter" style="width: 100%;">
                        <option value="">@lang('lang_v1.all')</option>
                        @foreach($leave_statuses as $key => $value)
                            <option value="{{$key}}">{{$value['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('leave_type_filter', __('essentials::lang.leave_type') . ':') !!}
                    {!! Form::select('leave_type_filter', $leave_types, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('leave_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('leave_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
        @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                        @component('components.widget', ['class' => 'box-solid', 'title' => __( 'essentials::lang.all_leaves' )])

                @slot('tool')
                    <div class="box-tools">
                       <button type="button"
                           class="tw-bg-[#2B7ADA] tw-rounded-xl tw-text-white tw-border-none
                            pull-right tw-dw-btn tw-px-4 tw-py-2 btn-brand hover:tw-bg-[#1f5bd8] tw-text-sm
                            tw-font-medium tw-flex tw-items-center tw-gap-2 btn-modal" style="background-color: #2B7ADA !important;"
                           data-href="{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveController::class, 'create'])}}"
                           data-container="#add_leave_modal">


                           <i class="fas fa-plus tw-text-xs"></i>
                           Add Leave
                       </button>
                    </div>




                @endslot
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="leave_table">
                        <thead>
                            <tr>
                                <th>@lang( 'purchase.ref_no' )</th>
                                <th>@lang( 'essentials::lang.leave_type' )</th>
                                <th>@lang('essentials::lang.employee')</th>
                                <th>@lang( 'lang_v1.date' )</th>
                                <th>@lang( 'essentials::lang.reason' )</th>
                                <th>@lang( 'sale.status' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row" id="user_leave_summary"></div>
</section>
<!-- /.content -->
<div class="modal fade" id="add_leave_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
 <div class="modal fade change_status_modal" id="change_status_modal"  tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
           leaves_table = $('#leave_table').DataTable({
               processing: true,
               serverSide: true,
               fixedHeader: false,
               dom:
                   "<'tw-flex tw-justify-between tw-items-center tw-mb-4'<'tw-flex tw-items-center'l><'tw-flex tw-items-center tw-gap-3'f<'filter-btn'>>>"
                   + "tr"
                   + "<'tw-flex tw-justify-between tw-items-center tw-mt-4'<'tw-text-sm'i><'tw-flex tw-items-center'p>>",

               ajax: {
                   "url": "{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveController::class, 'index'])}}",
                   "data": function(d) {
                       if ($('#user_id_filter').length) {
                           d.user_id = $('#user_id_filter').val();
                       }
                       d.status = $('#status_filter').val();
                       d.leave_type = $('#leave_type_filter').val();

                       if($('#leave_filter_date_range').val()) {
                           var start = $('#leave_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                           var end = $('#leave_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
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

               columnDefs: [
                   {
                       targets: 6,
                       orderable: false,
                       searchable: false,
                   },
               ],

               columns: [
                   { data: 'ref_no', name: 'ref_no' },
                   { data: 'leave_type', name: 'lt.leave_type' },
                   { data: 'user', name: 'user' },
                   { data: 'start_date', name: 'start_date'},
                   { data: 'reason', name: 'essentials_leaves.reason'},
                   { data: 'status', name: 'essentials_leaves.status'},
                   { data: 'action', name: 'action' },
               ],
           });


          let exportHtml = `
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


           $('#leave_table').closest('.dataTables_wrapper').append(exportHtml);



           $('.filter-btn').html(`
               <button id="openFilterModal"
                   class="tw-h-[44px] tw-border tw-border-gray-300 tw-bg-white hover:tw-bg-gray-50
                   tw-rounded-md tw-px-3 tw-text-[13px] tw-font-medium tw-flex tw-items-center tw-gap-2">
                   <i class="fas fa-filter tw-text-[12px] tw-text-gray-500"></i>
                   Filter
               </button>
           `);




            $('#leave_filter_date_range').daterangepicker(
                dateRangeSettings,
                function (start, end) {
                    $('#leave_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                }
            );
            $('#leave_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#leave_filter_date_range').val('');
                leaves_table.ajax.reload();
            });

            $(document).on( 'change', '#user_id_filter, #status_filter, #leave_filter_date_range, #leave_type_filter', function() {
                leaves_table.ajax.reload();
            });

            $('#add_leave_modal').on('shown.bs.modal', function(e) {
                $('#add_leave_modal .select2').select2();

                $('form#add_leave_form #start_date, form#add_leave_form #end_date').datepicker({
                    autoclose: true,
                });
            });

            $(document).on('submit', 'form#add_leave_form', function(e) {
                e.preventDefault();
                $(this).find('button[type="submit"]').attr('disabled', true);
                var data = $(this).serialize();
                var ladda = Ladda.create(document.querySelector('.add-leave-btn'));
                ladda.start();
                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        ladda.stop();
                        if (result.success == true) {
                            $('div#add_leave_modal').modal('hide');
                            toastr.success(result.msg);
                            leaves_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
            $(document).on( 'change', '#user_id_filter, #leave_filter_date_range', function() {
                get_leave_summary();
            });

            @if(!auth()->user()->can('essentials.crud_all_leave'))
                get_leave_summary();
            @endif
        });
        $(document).on('click', 'a.change_status', function(e) {
            e.preventDefault();
            // $('#change_status_modal').find('select#status_dropdown').val($(this).data('orig-value')).change();
            // $('#change_status_modal').find('#leave_id').val($(this).data('leave-id'));
            // $('#change_status_modal').find('#status_note').val($(this).data('status_note'));
            // $('#change_status_modal').modal('show');
            $.ajax({
                method: 'get',
                url: '/hrm/change-leave-status',
                dataType: 'html',
                data:{
                    id : $(this).data('leave-id'),
                },
                success: function(result) {
                        $('.change_status_modal')
                            .html(result)
                            .modal('show');
                            is_additional_hide_show();
                },
            });
        });

        $(document).on('submit', 'form#change_status_form', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var ladda = Ladda.create(document.querySelector('.update-leave-status'));
            ladda.start();
            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    ladda.stop();
                    if (result.success == true) {
                        $('div#change_status_modal').modal('hide');
                        toastr.success(result.msg);
                        leaves_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });

        $(document).on('click', 'button.delete-leave', function() {
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
                                leaves_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });

        function get_leave_summary() {
            $('#user_leave_summary').html('');
            var user_id = $('#user_id_filter').length ? $('#user_id_filter').val() : '';
            var start = $('#leave_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end = $('#leave_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            $.ajax({
                url: '{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveController::class, 'getUserLeaveSummary'])}}?user_id=' + user_id + '&start_date=' + start + '&end_date=' + end ,
                dataType: 'html',
                success: function(html) {
                    $('#user_leave_summary').html(html);
                },
            });
        }

        function is_additional_hide_show(){

            var status = $('#status_dropdown').val();
                if(status == 'approved'){
                    $('.is_additional').show();
                    $('#is_additional').prop('required', true);
                }else{
                    $('.is_additional').hide();
                    $('#is_additional').prop('required', false);
                }
        }

        $(document).on( 'change', '#status_dropdown', function() {
            is_additional_hide_show();
        });
    </script>
@endsection




<style>

.content {
    background: #f6f8fb !important;
}

table.dataTable thead th {
    font-size: 11px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: .04em !important;
    color: #6b7280 !important;
    padding: 12px 14px !important;
    border-bottom: 1px solid #e5e7eb !important;
}

table.dataTable tbody td {
    font-size: 13px;
    padding: 12px 14px;
    color: #374151;
}

table.dataTable tbody tr {
    border-bottom: 1px solid #f1f5f9;
}


.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    font-size: 13px;
    margin-bottom: 15px;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 6px 10px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #2B7ADA !important;
    border-radius: 6px !important;
    color: #fff !important;
    border: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 5px 10px !important;
    margin: 0 2px !important;
}

.dataTables_info {
    font-size: 13px;
    color: #6b7280;
}

</style>

<style>
    .dataTables_wrapper {
        padding-top: 10px;
    }

    .dataTables_length select {
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 4px 8px;
    }

   .dataTables_filter {
       position: relative;
   }

   .dataTables_filter input {
       height: 38px !important;
       width: 240px !important;
       padding: 0 35px 0 12px !important;
       border: 1px solid #d1d5db !important;
       border-radius: 6px !important;
       background-color: #fff !important;
       font-size: 13px !important;
   }

   .dataTables_filter:after {
       content: "\f002";
       font-family: "Font Awesome 5 Free";
       font-weight: 900;
       position: absolute;
       right: 10px;
       top: 9px;
       font-size: 12px;
       color: #9ca3af;
   }


    .dataTables_paginate {
        display: flex;
        align-items: center;
        gap: 4px;
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
/*     content: "\f002"; */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    right: 0;
    bottom: 8px;
    font-size: 12px;
    color: #9ca3af;
}



/* Also force on common components */
input,
textarea,
select,
button,
table,
th,
td,
span,
a,
p,
div,
h1, h2, h3, h4, h5, h6 {
    font-family: 'Roboto', sans-serif !important;
}


    </style>



