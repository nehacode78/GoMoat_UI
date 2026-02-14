@php
if($type == 'allowance') {
$name_col = 'payrolls['.$employee.'][allowance_names]';
$val_col = 'payrolls['.$employee.'][allowance_amounts]';
$val_class = 'allowance';
$type_col = 'payrolls['.$employee.'][allowance_types]';
$percent_col = 'payrolls['.$employee.'][allowance_percent]';
} elseif($type == 'deduction') {
$name_col = 'payrolls['.$employee.'][deduction_names]';
$val_col = 'payrolls['.$employee.'][deduction_amounts]';
$val_class = 'deduction';
$type_col = 'payrolls['.$employee.'][deduction_types]';
$percent_col = 'payrolls['.$employee.'][deduction_percent]';
}

$amount_type = !empty($amount_type) ? $amount_type : 'fixed';
$percent = $amount_type == 'percent' && !empty($percent) ? $percent : 0;
@endphp
<tr>
    <td>
        {!! Form::text($name_col . '[]', !empty($name) ? $name : null, ['class' => 'form-control input-sm' ]); !!}
    </td>
    <td>
        {!! Form::select(
        $type_col . '[]',
        [
        'fixed' => __('lang_v1.fixed'),
        'percent' => __('lang_v1.percentage')
        ],
        $amount_type,
        ['class' => 'form-control input-sm amount_type']
        ); !!}

        <div class="input-group percent_field @if($amount_type != 'percent') hide @endif">
            {!! Form::text($percent_col . '[]', @num_format($percent), [
            'class' => 'form-control input-sm input_number percent'
            ]) !!}
        </div>
    </td>
    <td>
        @php
        $readonly = $amount_type == 'percent' ? 'readonly' : '';
        @endphp
        {!! Form::text($val_col . '[]', !empty($value) ? @num_format((float) $value) : 0, ['class' => 'form-control
        input-sm value_field input_number ' . $val_class, $readonly ]); !!}
    </td>
    <td>
        @if(!empty($add_button))
        <button type="button"
            class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-primary @if($type == 'allowance') add_allowance @elseif($type == 'deduction') add_deduction @endif">
            <i class="fa fa-plus"></i>
            @else
            <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-error remove_tr"><i
                    class="fa fa-minus"></i></button>
            @endif
        </button>
    </td>
</tr>

<style>
/* Payroll main table */
.box-body {
    overflow-x: auto;
}

#payroll_table {
    border: 1px solid #e3e8ef;
    border-collapse: collapse;
    background-color: #ffffff;
}
 #payroll_table label {
        font-weight: normal;
    }

/* Header row */
#payroll_table th {
    background-color: #f9fafb;
    font-weight: 500;
    border: 1px solid #e3e8ef;
    padding: 10px;
}

/* Table rows */
#payroll_table tr {
    border: 1px solid #e3e8ef;
}

/* Table cells */
#payroll_table td {
    border: 1px solid #e3e8ef;
    padding: 10px;
    vertical-align: top;
}

/* Inner allowance & deduction tables */
.allowance_table,
.deductions_table {
    margin-bottom: 0;
}

.allowance_table th,
.deductions_table th {
    background-color: #f5f7fa;
    font-weight: 500;
    border-bottom: 1px solid #e3e8ef;
}

/* Inputs inside tables */
.allowance_table input,
.deductions_table input,
.allowance_table select,
.deductions_table select {
    height: 34px;
    font-size: 11px;
}

/* Total rows */
.allowance_table tfoot th,
.deductions_table tfoot th {
    font-weight: 500;
}

.allowance_table tfoot td,
.deductions_table tfoot td {
    font-weight: 500;
}

/* Gross amount column */
#gross_amount_text_ {
    font-size: 12px;
    font-weight: bold;
}

/* Spacing fix for widgets */
.box-body table table {
    margin-bottom: 0;
}

.gross-amount-wrap {
    float: right;
    text-align: right;
    margin-top: 8px;
}

.percent_field {
    display: none !important;
}

.amount_type {
    min-width: 105px;   
    white-space: nowrap;
}
.wd{
    margin-top: 40px;
}
</style>