@extends('layouts.app')
@section('title', __('account.balance_sheet'))

@section('content')
<section class="content">


    {{-- TABS --}}
    <ul class="crm-tabs">
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

    {{-- FILTERS --}}
    <div class="row no-print">
        <div class="col-sm-12">
            @component('components.filters', ['title' => __('report.filters')])

            {{-- Location --}}
            <div class="col-md-3" id="filter_location_bs">
                <div class="form-group">
                    {!! Form::label('bal_sheet_location_id', __('purchase.business_location') . ':') !!}
                    {!! Form::select('bal_sheet_location_id', $business_locations, null,
                        ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                </div>
            </div>
            <div class="col-md-3 tw-hidden" id="filter_location_tb">
                <div class="form-group">
                    {!! Form::label('trial_bal_location_id', __('purchase.business_location') . ':') !!}
                    {!! Form::select('trial_bal_location_id', $business_locations, null,
                        ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
                </div>
            </div>

            {{-- Date --}}
            <div class="col-sm-3 col-xs-6">
                <label for="end_date">@lang('messages.filter_by_date'):</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="end_date" value="{{ @format_date('now') }}"
                           class="form-control" readonly>
                </div>
            </div>

            @endcomponent
        </div>
    </div>

    <br>

    {{-- ======= BALANCE SHEET CONTENT ======= --}}
    <div id="content_bs">
        <div class="box box-solid">
            <div class="box-header print_section">
                <h3 class="box-title">
                    {{ session()->get('business.name') }} - @lang('account.balance_sheet') -
                    <span id="hidden_date">{{ @format_date('now') }}</span>
                </h3>
            </div>
            <div class="box-footer">
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white no-print pull-right"
                    onclick="window.print()">
                    <i class="fa fa-print"></i> @lang('messages.print')
                </button>
            </div>
            <div class="box-body">
                <table class="table table-border-center no-border table-pl-12">
                    <thead>
                        <tr class="bg-gray">
                            <th>@lang('account.liability')</th>
                            <th>@lang('account.assets')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="table">
                                    <tr>
                                        <th>@lang('account.supplier_due'):</th>
                                        <td>
                                            <input type="hidden" id="hidden_supplier_due" class="liability">
                                            <span class="remote-data" id="supplier_due">
                                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table" id="assets_table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('account.customer_due'):</th>
                                            <td>
                                                <input type="hidden" id="hidden_customer_due" class="asset">
                                                <span class="remote-data" id="customer_due">
                                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('report.closing_stock'):</th>
                                            <td>
                                                <input type="hidden" id="hidden_closing_stock" class="asset">
                                                <span class="remote-data" id="closing_stock">
                                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">@lang('account.account_balances'):</th>
                                        </tr>
                                    </tbody>
                                    <tbody id="account_balances" class="pl-20-td">
                                        <tr><td colspan="2"><i class="fas fa-sync fa-spin fa-fw"></i></td></tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray">
                            <td>
                                <table class="table bg-gray mb-0 no-border">
                                    <tr>
                                        <th>@lang('account.total_liability'):</th>
                                        <td>
                                            <span id="total_liabilty">
                                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table bg-gray mb-0 no-border">
                                    <tr>
                                        <th>@lang('account.total_assets'):</th>
                                        <td>
                                            <span id="total_assets">
                                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- ======= TRIAL BALANCE CONTENT ======= --}}
    <div id="content_tb" style="display:none;">
        <div class="box box-solid">
            <div class="box-header print_section">
                <h3 class="box-title">
                    {{ session()->get('business.name') }} - @lang('account.trial_balance') -
                    <span id="tb_hidden_date">{{ @format_date('now') }}</span>
                </h3>
            </div>
            <div class="box-footer">
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white no-print pull-right"
                    onclick="window.print()">
                    <i class="fa fa-print"></i> @lang('messages.print')
                </button>
            </div>
            <div class="box-body">
                <table class="table table-border-center-col no-border table-pl-12" id="trial_balance_table">
                    <thead>
                        <tr class="bg-gray">
                            <th>@lang('account.trial_balance')</th>
                            <th>@lang('account.debit')</th>
                            <th>@lang('account.credit')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>@lang('account.supplier_due'):</th>
                            <td>&nbsp;</td>
                            <td>
                                <input type="hidden" id="tb_hidden_supplier_due" class="tb_debit">
                                <span id="tb_supplier_due">
                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('account.customer_due'):</th>
                            <td>
                                <input type="hidden" id="tb_hidden_customer_due" class="tb_credit">
                                <span id="tb_customer_due">
                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                </span>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <th>@lang('account.account_balances'):</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                    <tbody id="tb_account_balances_details"></tbody>
                    <tfoot>
                        <tr class="bg-gray">
                            <th>@lang('sale.total')</th>
                            <td>
                                <span id="tb_total_credit">
                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                </span>
                            </td>
                            <td>
                                <span id="tb_total_debit">
                                    <i class="fas fa-sync fa-spin fa-fw"></i>
                                </span>
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

    // ===== TAB SWITCHING =====
    window.switchTab = function(tab) {
        // Hide all content
        $('#content_bs').hide();
        $('#content_tb').hide();

        // Reset all tabs
        $('#tab_li_bs').removeClass('active');
        $('#tab_li_tb').removeClass('active');

        // Show filter locations
        $('#filter_location_bs').hide();
        $('#filter_location_tb').hide();

        // Activate selected tab
        $('#content_' + tab).show();
        $('#tab_li_' + tab).addClass('active');

        if (tab === 'bs') {
            $('#filter_location_bs').show();
            $('#page_title').text('{{ __("account.balance_sheet") }}');
            update_balance_sheet();
        } else {
            $('#filter_location_tb').show();
            $('#page_title').text('{{ __("account.trial_balance") }}');
            update_trial_balance();
        }
    };

    // ===== INIT =====
    $('#end_date').datepicker({ autoclose: true, format: datepicker_date_format });

    // Load default tab
    switchTab('bs');

    // Filter changes
    $('#end_date').change(function () {
        $('#hidden_date, #tb_hidden_date').text($(this).val());
        if ($('#tab_li_bs').hasClass('active')) update_balance_sheet();
        else update_trial_balance();
    });

    $('#bal_sheet_location_id').change(function () { update_balance_sheet(); });
    $('#trial_bal_location_id').change(function () { update_trial_balance(); });
});

// ===== BALANCE SHEET =====
function update_balance_sheet() {
    var loader = '<i class="fas fa-sync fa-spin fa-fw"></i>';
    $('#supplier_due, #customer_due, #closing_stock, #total_liabilty, #total_assets').html(loader);
    $('#account_balances').html('<tr><td colspan="2">' + loader + '</td></tr>');

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

            $('#account_balances').html('');
            for (var key in result.account_balances) {
                var val = __currency_trans_from_en(result.account_balances[key]);
                var valSym = __currency_trans_from_en(result.account_balances[key], true);
                $('#account_balances').append(
                    '<tr><td class="pl-20-td">' + key + ':</td><td>' +
                    '<input type="hidden" class="asset" value="' + val + '">' +
                    valSym + '</td></tr>'
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

// ===== TRIAL BALANCE =====
function update_trial_balance() {
    var loader = '<i class="fas fa-sync fa-spin fa-fw"></i>';
    $('#tb_supplier_due, #tb_customer_due, #tb_total_credit, #tb_total_debit').html(loader);
    $('#tb_account_balances_details').html('<tr><td colspan="3">' + loader + '</td></tr>');

    $.ajax({
        url: "{{ action([\App\Http\Controllers\AccountReportsController::class, 'trialBalance']) }}"
            + "?end_date=" + $('#end_date').val()
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
                    '<tr><td class="pl-20-td">' + key + ':</td><td>' +
                    '<input type="hidden" class="tb_credit" value="' + val + '">' +
                    valSym + '</td><td>&nbsp;</td></tr>'
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
        font-weight:900;
        color:#9CA3AF;
        padding-bottom:10px;
        display:inline-block;
        text-transform: uppercase;
    }

    .crm-tabs li.active a{
        color:#276134;
        border-bottom:2px solid #276134;
    }


</style>