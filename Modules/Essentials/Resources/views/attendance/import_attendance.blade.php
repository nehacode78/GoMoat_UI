<!--

    <div class="row">
        <div class="col-sm-12">
            {!! Form::open(['url' => action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'importAttendance']), 'method' => 'post', 'enctype' => 'multipart/form-data' ]) !!}
                <div class="row">
                    <div class="col-sm-6">
                    <div class="col-sm-8">
                        <div class="form-group">
                            {!! Form::label('name', __( 'product.file_to_import' ) . ':') !!}
                            {!! Form::file('attendance', ['accept'=> '.xls', 'required' => 'required']); !!}
                          </div>
                    </div>
                    <div class="col-sm-4">
                    <br>
                        <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm">@lang('messages.submit')</button>
                    </div>
                    </div>
                </div>

            {!! Form::close() !!}
            <br><br>
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{ asset('modules/essentials/files/import_attendance_template.xls') }}" class="tw-dw-btn tw-dw-btn-success tw-text-white tw-dw-btn-sm" download><i class="fa fa-download"></i> @lang('lang_v1.download_template_file')</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table" width="100%">
                        <tr>
                            <th>@lang('lang_v1.col_no')</th>
                            <th>@lang('lang_v1.col_name')</th>
                            <th>@lang('lang_v1.instruction')</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>@lang('business.email') <small class="text-muted">(@lang('lang_v1.required'))</small></td>
                            <td>{!! __('essentials::lang.email_ins') !!}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>@lang('essentials::lang.clock_in_time') <small class="text-muted">(@lang('lang_v1.required'))</small></td>
                            <td>{!! __('essentials::lang.clock_in_time_ins') !!} ({{\Carbon::now()->toDateTimeString()}})</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>@lang('essentials::lang.clock_out_time') <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>{!! __('essentials::lang.clock_out_time_ins') !!} ({{\Carbon::now()->toDateTimeString()}})</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>@lang('essentials::lang.clock_in_note') <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>@lang('essentials::lang.clock_out_note') <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>@lang('essentials::lang.ip_address') <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    -->





    {{-- Header --}}
    <div class="import-header" style="padding-top:20px;" >
        <h4 class="import-title">
            <i class="fas fa-upload"></i>
            Import
        </h4>

        <a href="{{ asset('modules/essentials/files/import_attendance_template.xls') }}"
           class="download-template-btn"
           download>
            <i class="fa fa-download"></i>
            Download template file
        </a>
    </div>

    {{-- Upload Form --}}
    {!! Form::open([
        'url' => action([\Modules\Essentials\Http\Controllers\AttendanceController::class, 'importAttendance']),
        'method' => 'post',
        'enctype' => 'multipart/form-data'
    ]) !!}

        <div class="upload-box">
            <div>
                <label class="upload-label">FILE TO IMPORT</label>
                {!! Form::file('attendance', [
                    'accept'=> '.xls',
                    'required' => true,
                    'class' => 'upload-input'
                ]) !!}
            </div>

            <button type="submit"
                class="import-submit-btn"
                disabled>
                Submit
            </button>
        </div>

    {!! Form::close() !!}


    {{-- Instructions Table --}}
    <div class="import-table-wrapper">
        <table class="import-table">
            <thead>
                <tr>
                    <th>COLUMN NUMBER</th>
                    <th>COLUMN NAME</th>
                    <th>INSTRUCTIONS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Email <span class="text-muted">(required)</span></td>
                    <td>Email id of the user</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Clock in time <span class="text-muted">(required)</span></td>
                    <td>Clock in time in "Y-m-d H:i:s" format ({{ \Carbon\Carbon::now()->toDateTimeString() }})</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Clock out time <span class="text-muted">(optional)</span></td>
                    <td>Clock out time in "Y-m-d H:i:s" format ({{ \Carbon\Carbon::now()->toDateTimeString() }})</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Clock in note <span class="text-muted">(optional)</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Clock out note <span class="text-muted">(optional)</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>IP Address <span class="text-muted">(optional)</span></td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>



<style>

    /* ===== IMPORT CARD ===== */
    .import-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 24px;
        border: 1px solid #e5e7eb;
    }

    /* Header */
    .import-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
    }

    .import-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 16px;
        color: #1f2937;
    }

    /* Download Button */
    .download-template-btn {
        border: 1px solid #2B7ADA;
        color: #2B7ADA;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .download-template-btn:hover {
        background: #eff6ff;
    }

    /* Upload Box */
    .upload-box {
        border: 2px dashed #93c5fd;
        border-radius: 8px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        background: #f9fafb;
    }

    .upload-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        display: block;
        margin-bottom: 8px;
    }

    .upload-input {
        font-size: 13px;
    }

    /* Submit Button */
    .import-submit-btn {
        background: #D6D6D6;
        color: #fff;
        padding: 8px 18px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        font-weight: 500;
        opacity: 0.5;
        cursor: not-allowed;
    }

    .import-submit-btn.enabled {
        opacity: 1;
        cursor: pointer;
    }

    /* Table */
    .import-table-wrapper {
        overflow-x: auto;
    }

    .import-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .import-table thead {
        background: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
    }

    .import-table th,
    .import-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #e5e7eb;
    }
    </style>




