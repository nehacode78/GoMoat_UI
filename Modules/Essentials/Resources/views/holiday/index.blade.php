@extends('layouts.app')
@section('title', __('essentials::lang.holiday'))

@php
$canManageHoliday =
$is_admin ||
auth()->user()->can('essentials.edit_holiday') ||
auth()->user()->can('essentials.delete_holiday');

$canAddHoliday =
$is_admin ||
auth()->user()->can('essentials.add_holiday');
@endphp

@section('content')
@include('essentials::layouts.nav_hrm')
<!--
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.holiday')
        </h1>
    </section>
    -->
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters'), 'class' => 'box-solid'])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('location_id', __('purchase.business_location') . ':') !!}

                    {!! Form::select('location_id', $locations, null, ['class' => 'form-control select2', 'style' =>
                    'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('holiday_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('holiday_filter_date_range', null, ['placeholder' =>
                    __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-solid', 'title' => __( 'essentials::lang.all_holidays' )])
            @if($canAddHoliday)
           @slot('tool')
           <div class="box-tools">
               <button type="button"
                   class="tw-bg-[#2B7ADA] hover:tw-bg-[#1f5bd8]
                          tw-text-white tw-border-none
                          tw-rounded-xl
                          tw-px-4 tw-py-2
                          tw-text-sm tw-font-medium
                          tw-flex tw-items-center tw-gap-2 btn-modal"
                   style="background-color: #2B7ADA !important;"
                   data-href="{{action([\Modules\Essentials\Http\Controllers\EssentialsHolidayController::class, 'create'])}}"
                   data-container="#add_holiday_modal">

                   <i class="fas fa-plus tw-text-xs"></i>
                   Add Holiday
               </button>
           </div>
           @endslot
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="holidays_table">
                    <thead>
                        <tr>
                            <th>@lang( 'lang_v1.name' )</th>
                            <th>@lang( 'lang_v1.date' )</th>
                            <th>@lang( 'business.business_location' )</th>
                            <th>@lang( 'brand.note' )</th>
                            @if($canManageHoliday)
                            <th>@lang('messages.action')</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
            @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade" id="add_holiday_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
   holidays_table = $('#holidays_table').DataTable({
       processing: true,
       serverSide: true,
       fixedHeader: false,

       dom:
           "<'tw-flex tw-justify-between tw-items-center tw-mb-4'<'tw-flex tw-items-center'l><'tw-flex tw-items-center tw-gap-3'f>>"
           + "tr"
           + "<'tw-flex tw-justify-between tw-items-center tw-mt-4'<'tw-text-sm'i><'tw-flex tw-items-center'p>>",

       ajax: {
           url: "{{ action([\Modules\Essentials\Http\Controllers\EssentialsHolidayController::class, 'index']) }}",
           data: function(d) {
               d.location_id = $('#location_id').val();
               if ($('#holiday_filter_date_range').val()) {
                   d.start_date = $('#holiday_filter_date_range')
                       .data('daterangepicker').startDate.format('YYYY-MM-DD');
                   d.end_date = $('#holiday_filter_date_range')
                       .data('daterangepicker').endDate.format('YYYY-MM-DD');
               }
           }
       },

       @if($canManageHoliday)
       columnDefs: [{
           targets: -1,
           orderable: false,
           searchable: false,
       }],
       @endif

       columns: [
           { data: 'name', name: 'essentials_holidays.name' },
           { data: 'start_date', name: 'start_date' },
           { data: 'location', name: 'bl.name' },
           { data: 'note', name: 'note' }
           @if($canManageHoliday),
           { data: 'action', name: 'action' }
           @endif
       ]
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

              $('#holidays_table').closest('.dataTables_wrapper').append(exportHtml);

    $('#holiday_filter_date_range').daterangepicker(
        dateRangeSettings,
        function(start, end) {
            $('#holiday_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                moment_date_format));
        }
    );
    $('#holiday_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#holiday_filter_date_range').val('');
        holidays_table.ajax.reload();
    });

    $(document).on('change', '#holiday_filter_date_range, #location_id', function() {
        holidays_table.ajax.reload();
    });

    $('#add_holiday_modal').on('shown.bs.modal', function(e) {
        $('#add_holiday_modal .select2').select2();

        $('form#add_holiday_form #start_date, form#add_holiday_form #end_date').datepicker({
            autoclose: true,
        });
    });

    $(document).on('submit', 'form#add_holiday_form', function(e) {
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
                    $('div#add_holiday_modal').modal('hide');
                    toastr.success(result.msg);
                    holidays_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
});

$(document).on('click', 'button.delete-holiday', function() {
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
                        holidays_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        }
    });
});
</script>
@endsection

<style>

    /* Table header */
    table.dataTable thead th {
        font-size: 11px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: .04em !important;
        color: #6b7280 !important;
        padding: 12px 14px !important;
        border-bottom: 1px solid #e5e7eb !important;
    }

    /* Table body */
    table.dataTable tbody td {
        font-size: 13px;
        padding: 12px 14px;
        color: #374151;
    }

    table.dataTable tbody tr {
        border-bottom: 1px solid #f1f5f9;
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
    </style>