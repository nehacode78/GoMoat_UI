@extends('layouts.app')
@section('title', __('essentials::lang.payroll'))

@section('content')
@include('essentials::layouts.nav_hrm')
<!--
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.payroll')
        </h1>
    </section>

    -->

<!-- Main content -->

{{-- Tabs Section --}}
<div class="attendance-green-tabs no-print">
    <div class="green-tabs-wrapper" style="margin-left: 24px; margin-right: 24px;">
        <ul class="green-tabs-list" style="margin-top: -20px;">

           <li>
                                       <a href="#payroll_tab"
                                          data-toggle="tab"
                                          class="green-tab-link active">
                                           ALL PAYROLLS
                                       </a>
                                   </li>

                                   @can('essentials.view_all_payroll')
                                   <li>
                                       <a href="#payroll_group_tab"
                                          data-toggle="tab"
                                          class="green-tab-link">
                                           PAYROLL GROUPS
                                       </a>
                                   </li>
                                   @endcan

                                   @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                                   <li>
                                       <a href="#pay_component_tab"
                                          data-toggle="tab"
                                          class="green-tab-link">
                                           PAY COMPONENTS
                                       </a>
                                   </li>
                                   @endif

        </ul>
    </div>
</div>


<section class="content">
    <div class="row">
        <div class="col-md-12">

                  <div class="tab-content tw-px-4 table-bordered"
                         style="margin-top:20px; background-color:#F7F7F7;padding-top: 20px;">
                      <div class="tab-pane active" id="payroll_tab">
                        <div class="row">
                            <div class="col-md-12">
                                @component('components.filters', ['title' => __('report.filters'), 'class' => 'box-solid', 'closed' => true])
                                    @can('essentials.view_all_payroll')
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('user_id_filter', __('essentials::lang.employee') . ':') !!}
                                                {!! Form::select('user_id_filter', $employees, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('location_id_filter',  __('purchase.business_location') . ':') !!}

                                                {!! Form::select('location_id_filter', $locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('department_id', __('essentials::lang.department') . ':') !!}
                                                {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('designation_id', __('essentials::lang.designation') . ':') !!}
                                                {!! Form::select('designation_id', $designations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('month_year_filter', __( 'essentials::lang.month_year' ) . ':') !!}
                                            <div class="input-group">
                                                {!! Form::text('month_year_filter', null, ['class' => 'form-control', 'placeholder' => __( 'essentials::lang.month_year' ) ]); !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endcomponent
                            </div>
                        </div>

                        <div class="row">
                           @can('essentials.create_payroll')
                           <div class="tw-flex tw-justify-between tw-items-center tw-px-4"
                                style="border-radius: 6px; margin-bottom: -24px; ">

                               <div class="tw-flex tw-items-center tw-gap-2 tw-text-gray-800 tw-font-semibold tw-text-base">
                                   <i class="fas fa-coins tw-text-gray-600"></i>
                                   <span>All Payrolls</span>
                               </div>

                               <button type="button"
                                   class="tw-flex tw-items-center tw-gap-2  hover:tw-bg-blue-700 tw-text-white tw-font-medium tw-px-4 tw-py-2 tw-rounded-md tw-shadow-sm" style="background-color:#2B7ADA;"
                                   data-toggle="modal"
                                   data-target="#payroll_modal">

                                   <i class="fas fa-plus tw-text-sm"></i>
                                   <span>Add Payroll</span>
                               </button>
                           </div>
                        <br><br><br>
                           @endcan
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="payrolls_table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>@lang( 'essentials::lang.employee' )</th>
                                                <th>@lang( 'essentials::lang.department' )</th>
                                                <th>@lang( 'essentials::lang.designation' )</th>
                                                <th>@lang( 'essentials::lang.month_year' )</th>
                                                <th>@lang( 'purchase.ref_no' )</th>
                                                <th>@lang( 'sale.total_amount' )</th>
                                                <th>@lang( 'sale.payment_status' )</th>
                                                <th>@lang( 'messages.action' )</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    @can('essentials.view_all_payroll')
                        <div class="tab-pane" id="payroll_group_tab">
                            <div class="row">
                                @can('essentials.view_all_payroll')
                                <div class="tw-flex tw-justify-between tw-items-center tw-px-4"
                                     style="border-radius: 6px; margin-bottom: 34px;">

                                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-gray-800 tw-font-semibold tw-text-base">
                                        <i class="fas fa-folder-open tw-text-gray-600"></i>
                                        <span>All Payroll Groups</span>
                                    </div>

                                </div>
                                @endcan
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="payroll_group_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('essentials::lang.name')</th>
                                                    <th>@lang('sale.status')</th>
                                                    <th>@lang( 'sale.payment_status' )</th>
                                                    <th>@lang('essentials::lang.total_gross_amount')</th>
                                                    <th>@lang('lang_v1.added_by')</th>
                                                    <th>@lang('business.location')</th>
                                                    <th>@lang('lang_v1.created_at')</th>
                                                    <th>@lang( 'messages.action' )</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                        <div class="tab-pane" id="pay_component_tab">
                            <div class="row">
                               @can('essentials.add_allowance_and_deduction')
                               <div class="tw-flex tw-justify-between tw-items-center tw-px-4"
                                    style="border-radius: 6px; margin-bottom: 32px;">

                                   <div class="tw-flex tw-items-center tw-gap-2 tw-text-gray-800 tw-font-semibold tw-text-base">
                                       <i class="fas fa-sliders-h tw-mt-2 tw-text-gray-600"></i>
                                       <span>Pay Components</span>
                                   </div>

                                   <button type="button"
                                       class="tw-flex tw-items-center tw-gap-2 hover:tw-bg-blue-700 tw-text-white tw-font-medium tw-px-4 tw-py-2 tw-rounded-md tw-shadow-sm btn-modal" style="background-color:#2B7ADA;"
                                       data-href="{{action([\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController::class, 'create'])}}"
                                       data-container="#add_allowance_deduction_modal">

                                       <i class="fas fa-plus tw-text-sm"></i>
                                       <span>Add Component</span>
                                   </button>
                               </div>
                               @endcan
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="ad_pc_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang( 'lang_v1.description' )</th>
                                                    <th>@lang( 'lang_v1.type' )</th>
                                                    <th>@lang( 'sale.amount' )</th>
                                                    <th>@lang( 'essentials::lang.applicable_date' )</th>
                                                    <th>@lang( 'essentials::lang.employee' )</th>
                                                    <th>@lang( 'messages.action' )</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="user_leave_summary"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @can('essentials.create_payroll')
        @includeIf('essentials::payroll.payroll_modal')
    @endcan
    <div class="modal fade" id="add_allowance_deduction_modal" tabindex="-1" role="dialog"
 aria-labelledby="gridSystemModalLabel"></div>
</section>
<!-- /.content -->
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready( function(){
            payrolls_table = $('#payrolls_table').DataTable({

                processing: true,
                serverSide: true,
                fixedHeader:false,
                ajax: {
                    url: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'index'])}}",
                    data: function (d) {
                        if ($('#user_id_filter').length) {
                            d.user_id = $('#user_id_filter').val();
                        }
                        if ($('#location_id_filter').length) {
                            d.location_id = $('#location_id_filter').val();
                        }
                        d.month_year = $('#month_year_filter').val();
                        if ($('#department_id').length) {
                            d.department_id = $('#department_id').val();
                        }
                        if ($('#designation_id').length) {
                            d.designation_id = $('#designation_id').val();
                        }
                    },
                },
                columnDefs: [
                    {
                        targets: 7,
                        orderable: false,
                        searchable: false,
                    },
                ],
                aaSorting: [[4, 'desc']],
                columns: [
                    { data: 'user', name: 'user' },
                    { data: 'department', name: 'dept.name' },
                    { data: 'designation', name: 'dsgn.name' },
                    { data: 'transaction_date', name: 'transaction_date'},
                    { data: 'ref_no', name: 'ref_no'},
                    { data: 'final_total', name: 'final_total'},
                    { data: 'payment_status', name: 'payment_status'},
                    { data: 'action', name: 'action' },
                ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#payrolls_table'));
                },
            });


            let payrollExportHtml = `
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

                <a href="#" class="tw-text-blue-600 hover:tw-underline payroll-export-csv">CSV</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline payroll-export-xls">XLS</a>
                <a href="#" class="tw-text-blue-600 hover:tw-underline payroll-export-pdf">PDF</a>
            </div>
            `;

            $('#payrolls_table').closest('.dataTables_wrapper').append(payrollExportHtml);

            // Trigger exports
            $(document).on('click', '.payroll-export-csv', function(e) {
                e.preventDefault();
                payrolls_table.button('.buttons-csv').trigger();
            });
            $(document).on('click', '.payroll-export-xls', function(e) {
                e.preventDefault();
                payrolls_table.button('.buttons-excel').trigger();
            });
            $(document).on('click', '.payroll-export-pdf', function(e) {
                e.preventDefault();
                payrolls_table.button('.buttons-pdf').trigger();
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $('.green-tab-link').removeClass('active');
                $(e.target).addClass('active');
            });

            $(document).on('change', '#user_id_filter, #month_year_filter, #department_id, #designation_id, #location_id_filter', function() {
                payrolls_table.ajax.reload();
            });

            if ($('#add_payroll_step1').length) {
                $('#add_payroll_step1').validate();
                $('#employee_id').select2({
                    dropdownParent: $('#payroll_modal')
                });
            }

            $('div.view_modal').on('shown.bs.modal', function(e) {
                __currency_convert_recursively($('.view_modal'));
            });

            $('#month_year, #month_year_filter').datepicker({
                autoclose: true,
                format: 'mm/yyyy',
                minViewMode: "months"
            });

            //pay components
            @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                $('#add_allowance_deduction_modal').on('shown.bs.modal', function(e) {
                    var $p = $(this);
                    $('#add_allowance_deduction_modal .select2').select2({dropdownParent:$p});
                    $('#add_allowance_deduction_modal #applicable_date').datepicker();
                    
                });

                $(document).on('submit', 'form#add_allowance_form', function(e) {
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
                                $('div#add_allowance_deduction_modal').modal('hide');
                                toastr.success(result.msg);
                                ad_pc_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                });
                
                ad_pc_table = $('#ad_pc_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{action([\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController::class, 'index'])}}",
                    columns: [
                        { data: 'description', name: 'description' },
                        { data: 'type', name: 'type' },
                        { data: 'amount', name: 'amount' },
                        { data: 'applicable_date', name: 'applicable_date' },
                        { data: 'employees', searchable: false, orderable: false },
                        { data: 'action', name: 'action' }
                    ],
                    fnDrawCallback: function(oSettings) {
                        __currency_convert_recursively($('#ad_pc_table'));
                    },
                });

                $(document).on('click', '.delete-allowance', function(e) {
                    e.preventDefault();
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
                                        ad_pc_table.ajax.reload();
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                },
                            });
                        }
                    });
                });
            @endif
            //payroll groups
            @can('essentials.view_all_payroll')
                payroll_group_table = $('#payroll_group_table').DataTable({

                        processing: true,
                        serverSide: true,
                        fixedHeader:false,
                        ajax: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'payrollGroupDatatable'])}}",
                        aaSorting: [[6, 'desc']],
                        columns: [
                            { data: 'name', name: 'essentials_payroll_groups.name' },
                            { data: 'status', name: 'essentials_payroll_groups.status' },
                            { data: 'payment_status', name: 'essentials_payroll_groups.payment_status' },
                            { data: 'gross_total', name: 'essentials_payroll_groups.gross_total' },
                            { data: 'added_by', name: 'added_by' },
                            { data: 'location_name', name: 'BL.name' },
                            { data: 'created_at', name: 'essentials_payroll_groups.created_at', searchable: false},
                            { data: 'action', name: 'action', searchable: false, orderable: false}
                        ]
                    });
            @endcan
            @can('essentials.delete_payroll')
                $(document).on('click', '.delete-payroll', function(e) {
                    e.preventDefault();
                    swal({
                        title: LANG.sure,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then(willDelete => {
                        if (willDelete) {
                            var href = $(this).attr('href');
                            var data = $(this).serialize();

                            $.ajax({
                                method: 'DELETE',
                                url: href,
                                dataType: 'json',
                                data: data,
                                success: function(result) {
                                    if (result.success == true) {
                                        toastr.success(result.msg);
                                        payroll_group_table.ajax.reload();
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                },
                            });
                        }
                    });
                });
            @endcan

            $(document).on('change', '#primary_work_location', function () {
                let location_id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'getEmployeesBasedOnLocation'])}}",
                    dataType: 'json',
                    data: {
                        'location_id' : location_id
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $('select#employee_ids').html('');
                            $('select#employee_ids').html(result.employees_html);
                        }
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection


@section('css')
<style>
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


@endsection