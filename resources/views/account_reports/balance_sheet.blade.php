@extends('layouts.app')
@section('title', __('account.balance_sheet'))

@section('content')
<section class="content">


    {{-- TABS --}}
    <ul class="crm-tabs no-print">
        <li id="tab_li_bs" class="active">
            <a href="#" onclick="switchTab('bs'); return false;">
                {{ __('account.balance_sheet') }}
            </a>
        </li>
        <li id="tab_li_tb">
            <a href="#" onclick="switchTab('tb'); return false;">
                {{ __('account.trial_balance') }}
            </a>
        </li>
    </ul>

    {{-- ======= BALANCE SHEET CONTENT ======= --}}
    <div id="content_bs">

        {{-- FILTERS --}}
        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-ring-1 tw-ring-gray-200 tw-p-5 tw-mb-5 no-print">
            <div class="tw-flex tw-flex-wrap tw-items-end tw-gap-4">
                <div class="tw-flex  tw-gap-1 tw-min-w-[200px]">
                    <label class="tw-text-xs tw-mt-4 tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider">
                        {{ __('purchase.business_location') }}
                    </label>
                    {!! Form::select('bal_sheet_location_id', $business_locations, null,
                        ['class' => 'form-control select2', 'id' => 'bal_sheet_location_id', 'style' => 'width:100%']) !!}
                </div>
                <div class="tw-flex tw-gap-1 tw-min-w-[180px]">
                    <label class="tw-text-xs tw-mt-4 tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider">
                        {{ __('messages.filter_by_date') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" id="end_date" value="{{ @format_date('now') }}"
                               class="form-control" readonly>
                    </div>
                </div>
                <div class="tw-ml-auto">
                    <button type="button" onclick="window.print()"
                        class="tw-dw-btn tw-text-white no-print">
                        <i class="fa fa-print tw-mr-1"></i> {{ __('messages.print') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-ring-1 tw-ring-gray-200 tw-overflow-hidden">

            {{-- Print header --}}
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 print_section">
                <h3 class="tw-font-semibold tw-text-gray-700 tw-text-base">
                    {{ session()->get('business.name') }} — {{ __('account.balance_sheet') }} —
                    <span id="hidden_date">{{ @format_date('now') }}</span>
                </h3>
            </div>

            <div class="tw-p-6">
                <table class="tw-w-full tw-text-sm">
                    <thead>
                        <tr class="tw-border-b tw-border-gray-200">
                            <th class="tw-text-left tw-pb-3 tw-text-black-600 tw-font-bold tw-w-1/2">
                                {{ __('account.liability') }}
                            </th>
                            <th class="tw-text-left tw-pb-3 tw-text-black-600 tw-font-bold tw-w-1/2">
                                {{ __('account.assets') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tw-align-top">
                            {{-- LIABILITY COLUMN --}}
                            <td class="tw-py-4 tw-pr-8 tw-border-r tw-border-gray-100">
                                <div class="tw-flex tw-justify-between tw-py-2">
                                    <span class="tw-text-black-700 tw-font-bold">{{ __('account.supplier_due') }}:</span>
                                    <span id="supplier_due" class="tw-text-gray-900 tw-font-mono">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </span>
                                    <input type="hidden" id="hidden_supplier_due" class="liability">
                                </div>
                            </td>

                            {{-- ASSETS COLUMN --}}
                            <td class="tw-py-4 tw-pl-8">
                                <div class="tw-flex tw-justify-between tw-py-2">
                                    <span class="tw-text-black-700 tw-font-bold">{{ __('account.customer_due') }}:</span>
                                    <span id="customer_due" class="tw-text-gray-900 tw-font-mono">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </span>
                                    <input type="hidden" id="hidden_customer_due" class="asset">
                                </div>
                                <div class="tw-flex tw-justify-between tw-py-2">
                                    <span class="tw-text-black-700 tw-font-bold">{{ __('report.closing_stock') }}:</span>
                                    <span id="closing_stock" class="tw-text-gray-900 tw-font-mono">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </span>
                                    <input type="hidden" id="hidden_closing_stock" class="asset">
                                </div>

                                {{-- Account Balances --}}
                                <div class="tw-mt-2">
                                    <p class="tw-text-xs tw-mt-4 tw-font-bold tw-uppercase tw-tracking-wider tw-text-green-700 tw-mb-2">
                                        {{ __('account.account_balances') }}
                                    </p>
                                    <div id="account_balances_list">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="tw-border-t-2 tw-border-gray-200 tw-bg-gray-50">
                            <td class="tw-py-3 tw-pr-8 tw-border-r tw-border-gray-100">
                                <div class="tw-flex tw-justify-between">
                                    <span class="tw-font-bold tw-text-gray-800">{{ __('account.total_liability') }}:</span>
                                    <span id="total_liabilty" class="tw-font-bold tw-font-mono tw-text-gray-900">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="tw-py-3 tw-pl-8">
                                <div class="tw-flex tw-justify-between">
                                    <span class="tw-font-bold tw-text-gray-800">{{ __('account.total_assets') }}:</span>
                                    <span id="total_assets" class="tw-font-bold tw-font-mono tw-text-gray-900">
                                        <i class="fas fa-sync fa-spin fa-fw"></i>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- ======= TRIAL BALANCE CONTENT ======= --}}
    <div id="content_tb" style="display:none;">

        {{-- FILTERS --}}
        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-ring-1 tw-ring-gray-200 tw-p-5 tw-mb-5 no-print">
            <div class="tw-flex tw-flex-wrap tw-items-end tw-gap-4">
                <div class="tw-flex tw-gap-1 tw-min-w-[200px]">
                    <label class="tw-text-xs tw-mt-4 tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider">
                        {{ __('purchase.business_location') }}
                    </label>
                    {!! Form::select('trial_bal_location_id', $business_locations, null,
                        ['class' => 'form-control select2', 'id' => 'trial_bal_location_id', 'style' => 'width:100%']) !!}
                </div>
                <div class="tw-flex tw-gap-1 tw-min-w-[180px]">
                    <label class="tw-text-xs tw-mt-4 tw-font-semibold tw-text-gray-500 tw-uppercase tw-tracking-wider">
                        {{ __('messages.filter_by_date') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" id="tb_end_date" value="{{ @format_date('now') }}"
                               class="form-control" readonly>
                    </div>
                </div>
                <div class="tw-ml-auto">
                    <button type="button" onclick="window.print()"
                        class="tw-dw-btn  tw-text-white no-print">
                        <i class="fa fa-print tw-mr-1"></i> {{ __('messages.print') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-ring-1 tw-ring-gray-200 tw-overflow-hidden">

            {{-- Print header --}}
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 print_section">
                <h3 class="tw-font-semibold tw-text-gray-700 tw-text-base">
                    {{ session()->get('business.name') }} — {{ __('account.trial_balance') }} —
                    <span id="tb_hidden_date">{{ @format_date('now') }}</span>
                </h3>
            </div>

            <div class="tw-p-6">
                <table class="tw-w-full tw-text-sm">
                    <thead>
                        <tr class="tw-border-b tw-border-gray-200">
                            <th class="tw-text-left tw-pb-3 tw-text-black-600 tw-font-bold tw-w-1/2">
                                {{ __('account.trial_balance') }}
                            </th>
                            <th class="tw-text-right tw-pb-3 tw-text-gray-600 tw-font-semibold tw-w-1/4">
                                {{ __('account.debit') }}
                            </th>
                            <th class="tw-text-right tw-pb-3 tw-text-gray-600 tw-font-semibold tw-w-1/4">
                                {{ __('account.credit') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tw-border-b tw-border-gray-100">
                            <td class="tw-py-3  tw-text-black-700 tw-font-bold ">{{ __('account.supplier_due') }}:</td>
                            <td class="tw-py-3 tw-text-right tw-font-mono">&nbsp;</td>
                            <td class="tw-py-3 tw-text-right tw-font-mono">
                                <span id="tb_supplier_due"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                                <input type="hidden" id="tb_hidden_supplier_due" class="tb_debit">
                            </td>
                        </tr>
                        <tr class="tw-border-b tw-border-gray-100">
                            <td class="tw-py-3 tw-text-black-700 tw-font-bold">{{ __('account.customer_due') }}:</td>
                            <td class="tw-py-3 tw-text-right tw-font-mono">
                                <span id="tb_customer_due"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                                <input type="hidden" id="tb_hidden_customer_due" class="tb_credit">
                            </td>
                            <td class="tw-py-3 tw-text-right tw-font-mono">&nbsp;</td>
                        </tr>
                        <tr class="tw-border-b tw-border-gray-100">
                            <td colspan="3" class="tw-py-2">
                                <p class="tw-text-xs tw-mt-4 tw-font-bold tw-uppercase tw-tracking-wider tw-text-green-700 tw-mb-0">
                                    {{ __('account.account_balances') }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="tb_account_balances_details"></tbody>
                    <tfoot>
                        <tr class="tw-border-t-2 tw-border-gray-200 tw-bg-gray-50">
                            <td class="tw-py-3 tw-font-bold tw-text-gray-800">{{ __('sale.total') }}</td>
                            <td class="tw-py-3 tw-text-right tw-font-bold tw-font-mono">
                                <span id="tb_total_credit"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                            </td>
                            <td class="tw-py-3 tw-text-right tw-font-bold tw-font-mono">
                                <span id="tb_total_debit"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</section>
@stop

@section('javascript')
<script>
$(document).ready(function () {

    window.switchTab = function(tab) {
        $('#content_bs, #content_tb').hide();
        $('#tab_li_bs, #tab_li_tb').removeClass('active');
        $('#content_' + tab).show();
        $('#tab_li_' + tab).addClass('active');
        if (tab === 'bs') {
            $('#page_title').text('{{ __("account.balance_sheet") }}');
            update_balance_sheet();
        } else {
            $('#page_title').text('{{ __("account.trial_balance") }}');
            update_trial_balance();
        }
    };

    $('#end_date').datepicker({ autoclose: true, format: datepicker_date_format });
    $('#tb_end_date').datepicker({ autoclose: true, format: datepicker_date_format });

    switchTab('bs');

    $('#end_date').change(function () {
        $('#hidden_date').text($(this).val());
        update_balance_sheet();
    });
    $('#tb_end_date').change(function () {
        $('#tb_hidden_date').text($(this).val());
        update_trial_balance();
    });
    $('#bal_sheet_location_id').change(function () { update_balance_sheet(); });
    $('#trial_bal_location_id').change(function () { update_trial_balance(); });
});

function update_balance_sheet() {
    var loader = '<i class="fas fa-sync fa-spin fa-fw"></i>';
    $('#supplier_due, #customer_due, #closing_stock, #total_liabilty, #total_assets').html(loader);
    $('#account_balances_list').html(loader);

    $.ajax({
        url: "{{ action([\App\Http\Controllers\AccountReportsController::class, 'balanceSheet']) }}"
            + "?end_date=" + $('#end_date').val()
            + "&location_id=" + $('#bal_sheet_location_id').val(),
        dataType: "json",
        success: function (result) {
            $('#supplier_due').text(__currency_trans_from_en(result.supplier_due, true));
            __write_number($('#hidden_supplier_due'), result.supplier_due);
            $('#customer_due').text(__currency_trans_from_en(result.customer_due, true));
            __write_number($('#hidden_customer_due'), result.customer_due);
            $('#closing_stock').text(__currency_trans_from_en(result.closing_stock, true));
            __write_number($('#hidden_closing_stock'), result.closing_stock);

            $('#account_balances_list').html('');
            for (var key in result.account_balances) {
                var val = __currency_trans_from_en(result.account_balances[key]);
                var valSym = __currency_trans_from_en(result.account_balances[key], true);
                $('#account_balances_list').append(
                    '<div class="tw-flex tw-justify-between tw-py-1 tw-pl-3">' +
                    '<span class="tw-text-gray-600">' + key + ':</span>' +
                    '<span class="tw-font-mono tw-text-gray-900"><input type="hidden" class="asset" value="' + val + '">' + valSym + '</span>' +
                    '</div>'
                );
            }

            var total_liability = 0, total_assets = 0;
            $('.liability').each(function () { total_liability += __read_number($(this)); });
            $('.asset').each(function () { total_assets += __read_number($(this)); });
            $('#total_liabilty').text(__currency_trans_from_en(total_liability, true));
            $('#total_assets').text(__currency_trans_from_en(total_assets, true));
        }
    });
}

function update_trial_balance() {
    var loader = '<i class="fas fa-sync fa-spin fa-fw"></i>';
    $('#tb_supplier_due, #tb_customer_due, #tb_total_credit, #tb_total_debit').html(loader);
    $('#tb_account_balances_details').html('<tr><td colspan="3" class="tw-text-center tw-py-4">' + loader + '</td></tr>');

    $.ajax({
        url: "{{ action([\App\Http\Controllers\AccountReportsController::class, 'trialBalance']) }}"
            + "?end_date=" + $('#tb_end_date').val()
            + "&location_id=" + $('#trial_bal_location_id').val(),
        dataType: "json",
        success: function (result) {
            $('#tb_supplier_due').text(__currency_trans_from_en(result.supplier_due, true));
            __write_number($('#tb_hidden_supplier_due'), result.supplier_due);
            $('#tb_customer_due').text(__currency_trans_from_en(result.customer_due, true));
            __write_number($('#tb_hidden_customer_due'), result.customer_due);

            $('#tb_account_balances_details').html('');
            for (var key in result.account_balances) {
                var val = __currency_trans_from_en(result.account_balances[key]);
                var valSym = __currency_trans_from_en(result.account_balances[key], true);
                $('#tb_account_balances_details').append(
                    '<tr class="tw-border-b tw-border-gray-100">' +
                    '<td class="tw-py-2 tw-pl-4 tw-text-gray-600">' + key + ':</td>' +
                    '<td class="tw-py-2 tw-text-right tw-font-mono"><input type="hidden" class="tb_credit" value="' + val + '">' + valSym + '</td>' +
                    '<td class="tw-py-2">&nbsp;</td></tr>'
                );
            }

            var total_debit = 0, total_credit = 0;
            $('.tb_debit').each(function () { total_debit += __read_number($(this)); });
            $('.tb_credit').each(function () { total_credit += __read_number($(this)); });
            $('#tb_total_debit').text(__currency_trans_from_en(total_debit, true));
            $('#tb_total_credit').text(__currency_trans_from_en(total_credit, true));
        }
    });
}
</script>
@endsection

<style>
.crm-tabs {
    display: flex;
    gap: 0;
    border-bottom: 1px solid #E5E7EB;
    margin-bottom: 24px;
    padding-left: 0;
    list-style: none;
}
.crm-tabs li a {
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    color: #9CA3AF;
    padding: 12px 24px;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 2px solid transparent;
    transition: all 0.2s ease;
}
.crm-tabs li a:hover {
    color: #374151;
    border-bottom-color: #D1D5DB;
}
.crm-tabs li.active a {
    color: #276134;
    border-bottom: 2px solid #276134;
}
.tw-text-green-700{
color:#276134;
font-weight: 800;
}
.tw-dw-btn{
background-color:#2B7ADA !important;
border-color:#2B7ADA !important;
}
</style>