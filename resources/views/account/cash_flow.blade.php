@extends('layouts.app')
@section('title', __('lang_v1.cash_flow'))

@section('content')
<section class="content">


    {{-- MAIN CARD --}}
    <div class="tw-bg-white tw-px-4 tw-rounded-xl tw-shadow-sm tw-ring-1 tw-ring-gray-200 tw-overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="tw-flex tw-items-center tw-mt-4 tw-justify-between tw-px-6 tw-py-4 tw-border-gray-100">
            <div class="tw-flex tw-items-center tw-gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5 tw-text-gray-500" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="M7 16l4-4 4 4 4-4"/>
                </svg>
                <h2 class="tw-font-semibold tw-text-gray-800 tw-text-base">{{ __('lang_v1.cash_flow') }}</h2>
            </div>

            {{-- FILTER BUTTON --}}
            <button type="button" id="toggleFilters"
                class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-text-sm tw-font-medium
                       tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 tw-rounded-lg
                       hover:tw-bg-gray-50 tw-transition-all no-print">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 3H2l8 9.46V19l4 2V12.46L22 3z"/>
                </svg>
                {{ __('report.filters') }}
            </button>
        </div>

        {{-- FILTERS PANEL (hidden by default) --}}
        <div id="filtersPanel" class="tw-hidden tw-px-6 tw-py-4 tw-bg-gray-50 tw-border-b tw-border-gray-100 no-print">
            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4">
                <div>
                    <label class="tw-block tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider tw-mb-1">
                        {{ __('account.account') }}
                    </label>
                    {!! Form::select('account_id', $accounts, '', [
                        'class' => 'form-control select2',
                        'id' => 'account_id',
                        'placeholder' => __('messages.all'),
                        'style' => 'width:100%'
                    ]) !!}
                </div>
                <div>
                    <label class="tw-block tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider tw-mb-1">
                        {{ __('purchase.business_location') }}
                    </label>
                    {!! Form::select('cash_flow_location_id', $business_locations, null, [
                        'class' => 'form-control select2',
                        'id' => 'cash_flow_location_id',
                        'style' => 'width:100%'
                    ]) !!}
                </div>
                <div>
                    <label class="tw-block tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider tw-mb-1">
                        {{ __('report.date_range') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {!! Form::text('transaction_date_range', null, [
                            'class' => 'form-control',
                            'id' => 'transaction_date_range',
                            'readonly',
                            'placeholder' => __('report.date_range')
                        ]) !!}
                    </div>
                </div>
                <div>
                    <label class="tw-block tw-text-xs tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider tw-mb-1">
                        {{ __('account.transaction_type') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-exchange-alt"></i></span>
                        {!! Form::select('transaction_type', [
                            '' => __('messages.all'),
                            'debit' => __('account.debit'),
                            'credit' => __('account.credit')
                        ], '', ['class' => 'form-control', 'id' => 'transaction_type']) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        @can('account.access')
        <div class="tw-p-6">
            <div class="tw-overflow-x-auto">
                <table class="table table-bordered table-striped" id="cash_flow_table" style="width:100%;">
                    <thead>
                        <tr>
                            <th>@lang('messages.date')</th>
                            <th>@lang('account.account')</th>
                            <th>@lang('lang_v1.description')</th>
                            <th>@lang('lang_v1.payment_method')</th>
                            <th>@lang('lang_v1.payment_details')</th>
                            <th>@lang('account.debit')</th>
                            <th>@lang('account.credit')</th>
                            <th>
                                @lang('lang_v1.account_balance')
                                @show_tooltip(__('lang_v1.account_balance_tooltip'))
                            </th>
                            <th>
                                @lang('lang_v1.total_balance')
                                @show_tooltip(__('lang_v1.total_balance_tooltip'))
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="background-color: #d1fae5; font-weight: bold;">
                            <td colspan="5" class="tw-text-right tw-font-bold tw-text-gray-800">
                                <strong>@lang('sale.total'):</strong>
                            </td>
                            <td class="footer_total_debit tw-font-bold tw-text-gray-900 tw-font-mono"></td>
                            <td class="footer_total_credit tw-font-bold tw-text-gray-900 tw-font-mono"></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
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
        @endcan

    </div>

    <div class="modal fade account_model" tabindex="-1" role="dialog"></div>

</section>
@endsection

@section('javascript')
<script>
$(document).ready(function () {

    {{-- Toggle filters panel --}}
    $('#toggleFilters').on('click', function () {
        $('#filtersPanel').toggleClass('tw-hidden');
        $(this).toggleClass('tw-bg-blue-50 tw-border-blue-300 tw-text-blue-600');
    });



    $('#transaction_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#transaction_date_range').val(
                start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
            );
            cash_flow_table.ajax.reload();
        }
    );

    cash_flow_table = $('#cash_flow_table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: false,
        ajax: {
            url: "{{ action([\App\Http\Controllers\AccountController::class, 'cashFlow']) }}",
            data: function (d) {
                var start = '', end = '';
                if ($('#transaction_date_range').val() != '') {
                    start = $('#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end   = $('#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
                d.account_id  = $('#account_id').val();
                d.type        = $('#transaction_type').val();
                d.start_date  = start;
                d.end_date    = end;
                d.location_id = $('#cash_flow_location_id').val();
            }
        },
        ordering: false,
        columns: [
            { data: 'operation_date',   name: 'operation_date' },
            { data: 'account_name',     name: 'A.name' },
            { data: 'sub_type',         name: 'sub_type',        searchable: false },
            { data: 'method',           name: 'TP.method' },
            { data: 'payment_details',  name: 'TP.payment_ref_no' },
            { data: 'debit',            name: 'amount',          searchable: false },
            { data: 'credit',           name: 'amount',          searchable: false },
            { data: 'balance',          name: 'balance',         searchable: false },
            { data: 'total_balance',    name: 'total_balance',   searchable: false },
        ],
        fnDrawCallback: function () {
            __currency_convert_recursively($('#cash_flow_table'));
        },
        footerCallback: function (row, data) {
            var footer_total_debit  = 0;
            var footer_total_credit = 0;
            for (var r in data) {
                footer_total_debit  += $(data[r].debit).data('orig-value')  ? parseFloat($(data[r].debit).data('orig-value'))  : 0;
                footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(data[r].credit).data('orig-value')) : 0;
            }
            $('.footer_total_debit').html(__currency_trans_from_en(footer_total_debit));
            $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
        }
    });

    $('#transaction_type, #account_id, #cash_flow_location_id').change(function () {
        cash_flow_table.ajax.reload();
    });

    $('#transaction_date_range').on('cancel.daterangepicker', function () {
        $(this).val('').change();
        cash_flow_table.ajax.reload();
    });
});
</script>
@endsection

<style>
/* Green total footer row */
#cash_flow_table tfoot tr {
    background-color:#D9ECDD !important;
}
#cash_flow_table tfoot td {
    font-weight: 700;
    color: #065f46;
    font-size: 14px;
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
.tw-font-semibold{
font-weight:700 !important;

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

</style>