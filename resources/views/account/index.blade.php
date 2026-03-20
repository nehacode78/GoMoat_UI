@extends('layouts.app')
@section('title', __('lang_v1.payment_accounts'))

@section('content')
    <!-- Content Header (Page header) -->

    <!--

    <section class="content-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('lang_v1.payment_accounts')
                <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('account.manage_your_account')</small>
            </h1>
        </section>

    -->



    <!-- Main content -->
    <section class="content">
       @if (!empty($not_linked_payments))
       <div class="custom-alert">
           <span>
               Total {{ $not_linked_payments }} payments not linked with any account.
           </span>
           <a href="{{ action([\App\Http\Controllers\AccountReportsController::class, 'paymentAccountReport']) }}">
               View Details
           </a>
       </div>
       @endif
        @can('account.access')

            <ul class="crm-tabs">
                <li class="active">
                    <a href="#other_accounts" data-toggle="tab">
                        @lang('account.accounts')
                    </a>
                </li>
                <li>
                    <a href="#account_types" data-toggle="tab">
                        @lang('lang_v1.account_types')
                    </a>
                </li>
                <li>
                    <a href="#payment_account_report_tab" data-toggle="tab">
                        @lang('account.payment_account_report')
                    </a>
                </li>
            </ul>
            <div class="row">
                @component('components.widget')
                    <div class="col-sm-12">

                        <div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="other_accounts">
                                    <div class="row">
                                        <div class="col-12">

                                            {{-- @component('components.widget') --}}
                                           <div class="account-header-bar">

                                               <!-- LEFT SIDE -->
                                               <div class="account-header-left">
                                                   <div class="account-icon">
                                                       <i class="fa fa-credit-card"></i>
                                                   </div>
                                                   <span class="account-title-text">
                                                       Payment Accounts
                                                   </span>
                                               </div>

                                               <!-- RIGHT SIDE -->
                                               <button type="button"
                                                   class="add-account-btn btn-modal"
                                                   data-container=".account_model"
                                                   data-href="{{ action([\App\Http\Controllers\AccountController::class, 'create']) }}">
                                                   <i class="fa fa-plus"></i> Add Payment Account
                                               </button>

                                           </div>
                                            {{-- @endcomponent --}}
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                            <div class="account-table-card">

                                                    <table class="table account-modern-table" id="other_account_table">
                                                     <thead>
                                                        <tr>
                                                            <th>@lang('lang_v1.name')</th>
                                                            <th>@lang('lang_v1.account_type')</th>
                                                            <th>@lang('lang_v1.account_sub_type')</th>
                                                            <th>@lang('account.account_number')</th>
                                                            <th>@lang('brand.note')</th>
                                                            <th>@lang('lang_v1.balance')</th>
                                                            <th>@lang('lang_v1.account_details')</th>
                                                            <th>@lang('lang_v1.added_by')</th>
                                                            <th>@lang('messages.action')</th>
                                                        </tr>
                                                     </thead>
                                                    <tfoot>
                                                        <tr class="account-total-row">
                                                            <td colspan="5">TOTAL:</td>
                                                            <td class="footer_total_balance"></td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>


                                            <div class="account-export-section">

                                                <!-- ICONS -->
                                                <div class="export-icons">
                                                    <div class="export-icon">
                                                        <i class="fa fa-print"></i>
                                                    </div>
                                                    <div class="export-icon">
                                                        <i class="fa fa-file"></i>
                                                    </div>
                                                </div>

                                                <!-- TEXT -->
                                                <span class="export-label">Export:</span>

                                                <!-- LINKS -->
                                                <a href="#" class="export-btn export-csv">CSV</a>
                                                <a href="#" class="export-btn export-xls">XLS</a>
                                                <a href="#" class="export-btn export-pdf">PDF</a>

                                            </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--
                    <div class="tab-pane" id="capital_accounts">
                        <table class="table table-bordered table-striped" id="capital_account_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang( 'lang_v1.name' )</th>
                                    <th>@lang('account.account_number')</th>
                                    <th>@lang( 'brand.note' )</th>
                                    <th>@lang('lang_v1.balance')</th>
                                    <th>@lang( 'messages.action' )</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    --}}
                                <div class="tab-pane" id="account_types">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <!-- HEADER BAR -->
                                            <div class="account-header-bar">

                                                <!-- LEFT -->
                                                <div class="account-header-left">
                                                    <div class="account-icon">
                                                        <i class="fa fa-layer-group"></i>
                                                    </div>
                                                    <span class="account-title-text">
                                                        Account Types
                                                    </span>
                                                </div>

                                                <!-- RIGHT -->
                                                <button type="button"
                                                    class="add-account-btn btn-modal"
                                                    data-href="{{ action([\App\Http\Controllers\AccountTypeController::class, 'create']) }}"
                                                    data-container="#account_type_modal">
                                                    <i class="fa fa-plus"></i> Add Account Type
                                                </button>

                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <br>

                                            <div class="account-table-card">

                                                <table class="table account-modern-table" id="account_types_table" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('lang_v1.name')</th>
                                                            <th>@lang('messages.action')</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($account_types as $account_type)

                                                            <!-- MAIN TYPE -->
                                                            <tr class="account_type_{{ $account_type->id }}">
                                                                <td>
                                                                    <strong>{{ $account_type->name }}</strong>
                                                                </td>
                                                                <td>

                                                                    {!! Form::open([
                                                                        'url' => action([\App\Http\Controllers\AccountTypeController::class, 'destroy'], $account_type->id),
                                                                        'method' => 'delete',
                                                                    ]) !!}

                                                                    <button type="button"
                                                                        class="btn btn-xs btn-light btn-modal"
                                                                        data-href="{{ action([\App\Http\Controllers\AccountTypeController::class, 'edit'], $account_type->id) }}"
                                                                        data-container="#account_type_modal">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>

                                                                    <button type="button"
                                                                        class="btn btn-xs btn-light delete_account_type">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>

                                                                    {!! Form::close() !!}

                                                                </td>
                                                            </tr>

                                                            <!-- SUB TYPES -->
                                                            @foreach ($account_type->sub_types as $sub_type)
                                                                <tr>
                                                                    <td style="padding-left:30px; color:#6B7280;">
                                                                        — {{ $sub_type->name }}
                                                                    </td>
                                                                    <td>

                                                                        {!! Form::open([
                                                                            'url' => action([\App\Http\Controllers\AccountTypeController::class, 'destroy'], $sub_type->id),
                                                                            'method' => 'delete',
                                                                        ]) !!}

                                                                        <button type="button"
                                                                            class="btn btn-xs btn-light btn-modal"
                                                                            data-href="{{ action([\App\Http\Controllers\AccountTypeController::class, 'edit'], $sub_type->id) }}"
                                                                            data-container="#account_type_modal">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>

                                                                        <button type="button"
                                                                            class="btn btn-xs btn-light delete_account_type">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>

                                                                        {!! Form::close() !!}

                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>

                                </div>



                            <div class="tab-pane" id="payment_account_report_tab">

                                <!-- HEADER -->
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="account-header-bar">

                                            <!-- LEFT -->
                                            <div class="account-header-left">
                                                <div class="account-icon">
                                                    <i class="fa fa-file-alt"></i>
                                                </div>
                                                <span class="account-title-text">
                                                    Payment Account Report
                                                </span>
                                            </div>

                                        </div>

                                    </div>
                                </div>



                                <!-- TABLE -->
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="account-table-card">

                                            <table class="table account-modern-table" id="payment_account_report">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('messages.date')</th>
                                                        <th>@lang('account.payment_ref_no')</th>
                                                        <th>@lang('account.invoice_ref_no')</th>
                                                        <th>@lang('sale.amount')</th>
                                                        <th>@lang('lang_v1.payment_type')</th>
                                                        <th>@lang('account.account')</th>
                                                        <th>@lang('lang_v1.description')</th>
                                                        <th>@lang('messages.action')</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <!-- EXPORT -->
                                            <div class="account-export-section">

                                                <div class="export-icons">
                                                    <div class="export-icon">
                                                        <i class="fa fa-print"></i>
                                                    </div>
                                                    <div class="export-icon">
                                                        <i class="fa fa-file"></i>
                                                    </div>
                                                </div>

                                                <span class="export-label">Export:</span>

                                                <a href="#" class="export-btn report-csv">CSV</a>
                                                <a href="#" class="export-btn report-xls">XLS</a>
                                                <a href="#" class="export-btn report-pdf">PDF</a>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>


                            </div>
                        </div>
                    </div>
                @endcomponent
            </div>
        @endcan

        <div class="modal fade account_model" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"
            id="account_type_modal">
        </div>
    </section>
    <!-- /.content -->

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {

        setTimeout(function () {

            let filterHtml = `
                <button class="filter-btn">
                    <i class="fa fa-filter"></i> Filter
                </button>
            `;

            $('#payment_account_report_filter').append(filterHtml);

        }, 500);

            $(document).on('click', 'button.close_account', function() {
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var url = $(this).data('url');

                        $.ajax({
                            method: "get",
                            url: url,
                            dataType: "json",
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    capital_account_table.ajax.reload();
                                    other_account_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }

                            }
                        });
                    }
                });
            });

            $(document).on('click','.export-csv',function(e){
                e.preventDefault();
                $('.buttons-csv').click();
            });

            $(document).on('click','.export-xls',function(e){
                e.preventDefault();
                $('.buttons-excel').click();
            });

            $(document).on('click','.export-pdf',function(e){
                e.preventDefault();
                $('.buttons-pdf').click();
            });

            $(document).on('submit', 'form#edit_payment_account_form', function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            capital_account_table.ajax.reload();
                            other_account_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            });

            $(document).on('submit', 'form#payment_account_form', function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    method: "post",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            capital_account_table.ajax.reload();
                            other_account_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            });

            // capital_account_table
            capital_account_table = $('#capital_account_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader:false,
                ajax: '/account/account?account_type=capital',
                columnDefs: [{
                    "targets": 5,
                    "orderable": false,
                    "searchable": false
                }],
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'note',
                        name: 'note'
                    },
                    {
                        data: 'balance',
                        name: 'balance',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#capital_account_table'));
                }
            });
            // capital_account_table
            other_account_table = $('#other_account_table').DataTable({
                processing: true,
                serverSide: true,
                fixedHeader:false,



                ajax: {
                    url: '/account/account?account_type=other',
                    data: function(d) {
                        d.account_status = $('#account_status').val();
                    }
                },
                columnDefs: [{
                    "targets": [6, 8],
                    "orderable": false,
                    "searchable": false
                }],
                columns: [{
                        data: 'name',
                        name: 'accounts.name'
                    },
                    {
                        data: 'parent_account_type_name',
                        name: 'pat.name'
                    },
                    {
                        data: 'account_type_name',
                        name: 'ats.name'
                    },
                    {
                        data: 'account_number',
                        name: 'accounts.account_number'
                    },
                    {
                        data: 'note',
                        name: 'accounts.note'
                    },
                    {
                        data: 'balance',
                        name: 'balance',
                        searchable: false
                    },
                    {
                        data: 'account_details',
                        name: 'account_details'
                    },
                    {
                        data: 'added_by',
                        name: 'u.first_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnDrawCallback": function(oSettings) {
                    __currency_convert_recursively($('#other_account_table'));
                },
                "footerCallback": function(row, data, start, end, display) {
                    var footer_total_balance = 0;
                    for (var r in data) {
                        footer_total_balance += $(data[r].balance).data('orig-value') ? parseFloat($(
                            data[r].balance).data('orig-value')) : 0;
                    }

                    $('.footer_total_balance').html(__currency_trans_from_en(footer_total_balance));
                }
            });

        });

        $('#account_status').change(function() {
            other_account_table.ajax.reload();
        });

        $(document).on('submit', 'form#deposit_form', function(e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                method: "POST",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('div.view_modal').modal('hide');
                        toastr.success(result.msg);
                        capital_account_table.ajax.reload();
                        other_account_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        });

        $('.account_model').on('shown.bs.modal', function(e) {
            $('.account_model .select2').select2({
                dropdownParent: $(this)
            })
        });

        $(document).on('click', 'button.delete_account_type', function() {
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $(this).closest('form').submit();
                }
            });
        })

        $(document).on('click', 'button.activate_account', function() {
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willActivate) => {
                if (willActivate) {
                    var url = $(this).data('url');
                    $.ajax({
                        method: "get",
                        url: url,
                        dataType: "json",
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                capital_account_table.ajax.reload();
                                other_account_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }

                        }
                    });
                }
            });
        });




        // Payment Account Report Table
        payment_account_report = $('#payment_account_report').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader:false,
            ajax: {
                url: "{{ action([\App\Http\Controllers\AccountReportsController::class, 'paymentAccountReport']) }}",
                data: function(d) {

                    d.account_id = $('#account_id').val();

                    var start_date = '';
                    var end_date = '';

                    if ($('#date_filter').val()) {
                        start_date = $('#date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        end_date = $('#date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    }

                    d.start_date = start_date;
                    d.end_date = end_date;
                }
            },
            columnDefs: [{
                targets: 7,
                orderable: false,
                searchable: false
            }],
            columns: [
                {data: 'paid_on', name: 'paid_on'},
                {data: 'payment_ref_no', name: 'payment_ref_no'},
                {data: 'transaction_number', name: 'transaction_number'},
                {data: 'amount', name: 'amount'},
                {data: 'type', name: 'T.type'},
                {data: 'account', name: 'account'},
                {data: 'details', name: 'details', searchable:false},
                {data: 'action', name: 'action'}
            ],

            fnDrawCallback: function(oSettings){
                __currency_convert_recursively($('#payment_account_report'));
            }
        });

        $('select#account_id, #date_filter').change(function(){
            payment_account_report.ajax.reload();
        });


    </script>
@endsection

<style>
  .account-table-card {
      width: 100%;
      padding: 10px; /* reduce from 15px */
  }

    /* Make top controls full width */
    .dataTables_wrapper .row:first-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    /* Left side (entries dropdown) */
    .dataTables_length {
        flex: 1;
    }


    /* Right side (search + filter) */
    .dataTables_filter {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }
    #payment_account_report_filter {
        display: flex;
        align-items: center;
        gap: 12px;
    }

   .filter-btn {
       display: inline-flex;
       align-items: center;
       gap: 6px;
       padding: 6px 14px;
       font-size: 12px;
       font-weight: 500;
       color: #374151;
       background: #F9FAFB;
       border: 1px solid #D1D5DB;
       border-radius: 8px;
       cursor: pointer;
       transition: all 0.2s ease;
       margin-left: 6px;
   }

   /* Hover */
   .filter-btn:hover {
       background: #F3F4F6;
       border-color: #9CA3AF;
   }

   /* Icon */
   .filter-btn i {
       font-size: 11px;
       color: #6B7280;
   }

    /* Export Section */
    .account-export-section{
        display:flex;
        align-items:center;
        gap:10px;
        margin-top:12px;
        font-size:12px;
        color:#6B7280;
    }

    /* Icons */
    .export-icons{
        display:flex;
        gap:6px;
    }

    .export-icon{
        width:26px;
        height:26px;
        border:1px solid #E5E7EB;
        border-radius:6px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:12px;
        color:#6B7280;
        background:#fff;
    }

    /* Label */
    .export-label{
        font-weight:500;
    }

    /* Buttons */
    .export-btn{
        color:#2B7ADA;
        text-decoration:none;
        font-weight:500;
    }

    .export-btn:hover{
        text-decoration:underline;
    }
.crm-tabs{
        display:flex;
        gap:30px;
        border-bottom:1px solid #E5E7EB;
        margin-bottom:20px;
        padding-left:0;
        list-style:none;
    }

    .crm-tabs li a{
        text-decoration:none;
        font-size:14px;
        letter-spacing:.08em;
        font-weight:700;
        color:#9CA3AF;
        padding-bottom:10px;
        display:inline-block;
        text-transform: uppercase;
    }

    .crm-tabs li.active a{
        color:#276134;
        border-bottom:2px solid #276134;
    }




/* Card Container */
.account-table-card{
    background:#F7F7F7;
    border-radius:10px;
/*     padding:15px; */
/*     box-shadow:0 2px 8px rgba(0,0,0,0.04); */
}

/* Table Base */
.account-modern-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

/* Header */
.account-modern-table thead th{
    font-size:11px;
    text-transform:uppercase;
    color:#9CA3AF;
    font-weight:600;
    border-bottom:1px solid #E5E7EB;
    padding:10px;
}

/* Body */
.account-modern-table tbody td{
    font-size:13px;
    color:#374151;
    padding:12px 10px;
    border-bottom:1px solid #F3F4F6;
}

/* Hover */
.account-modern-table tbody tr:hover{
    background:#F9FAFB;
}

/* Total Row */
.account-total-row{
    background:#D9ECDD;
    font-weight:600;
}

.account-total-row td{
    padding:12px;
    border:none;
}

/* Amount column */
.account-modern-table td:nth-child(6){
    text-align:right;
    font-weight:600;
}

/* Action buttons */
.account-modern-table .btn{
    padding:4px 8px;
    font-size:11px;
    border-radius:6px;
}
/* Filter + Search alignment */
.dataTables_wrapper .dataTables_filter input{
    border:none;
    border-bottom:1px solid #E5E7EB;
    background:transparent;
}

/* Pagination */
.dataTables_wrapper .dataTables_paginate{
    margin-top:10px;
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

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: -3.5em !important;
    display: inline-block;
    width: auto;
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



/* Header Bar */
.account-header-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
}

/* Left side */
.account-header-left{
    display:flex;
    align-items:center;
    gap:8px;
}

/* Icon */
.account-icon{
    width:28px;
    height:28px;
    border:1px solid #E5E7EB;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#6B7280;
    font-size:13px;
    background:#fff;
}

/* Text */
.account-title-text{
    font-size:14px;
    font-weight:600;
    color:#374151;
}

/* Button */
.add-account-btn{
    background:#2B7ADA;
    color:#fff;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    font-size:13px;
    display:flex;
    align-items:center;
    gap:6px;
}

.add-account-btn:hover{
    background:#1D4ED8;
}

/* Full width wrapper */
.dataTables_wrapper {
    width: 100% !important;
}

/* Table container full width */
.dataTables_wrapper .dataTables_scroll,
.dataTables_wrapper .dataTables_scrollBody,
.dataTables_wrapper .dataTables_scrollHead {
    width: 100% !important;
}

/* Table itself */
#payment_account_report {
    width: 100% !important;
}

</style>
