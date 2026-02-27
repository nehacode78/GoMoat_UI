@extends('layouts.app')
@section('title', __('essentials::lang.essentials_n_hrm_settings'))

@section('content')
    @include('essentials::layouts.nav_hrm')
    <!-- Content Header (Page header) -->

    <!--

    <section class="content-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.essentials_n_hrm_settings')</h1>
        </section>
    -->


    <!-- Main content -->
    <section class="content">
        {!! Form::open([
            'action' => '\Modules\Essentials\Http\Controllers\EssentialsSettingsController@update',
            'method' => 'post',
            'id' => 'essentials_settings_form',
        ]) !!}
        <div class="row">
            <div class="col-xs-12">
                <!--  <pos-tab-container> -->
                {{-- <div class="col-xs-12 pos-tab-container"> --}}
                @component('components.widget', ['class' => 'box-solid'])

                    <div class="tw-space-y-8">


                        <div>
                            <h4 class="tw-font-semibold tw-text-lg tw-mb-4">Leave</h4>
                            @include('essentials::settings.partials.leave_settings')
                        </div>

                    <div class="row" style="margin-top:20px;">

                        {{-- Payroll --}}
                        <div class="col-md-6 col-sm-6">
                            <div class="tw-rounded-lg tw-p-2 tw-border tw-border-gray-200">
                                <h4 class="tw-font-semibold tw-text-lg tw-mb-4">Payroll Settings</h4>
                                @include('essentials::settings.partials.payroll_settings')
                            </div>
                        </div>

                        {{-- Sales Targets --}}
                        <div class="col-md-6 col-sm-6">
                            <div class="tw-rounded-lg tw-p-2 tw-border tw-border-gray-200">
                                <h4 class="tw-font-semibold tw-text-sm tw-mb-4">Sales Target Settings</h4>
                                @include('essentials::settings.partials.sales_target_settings')
                            </div>
                        </div>



                    </div>

                        <div>
                            <h4 class="tw-font-semibold tw-text-lg tw-mb-4">Attendance Settings</h4>
                            @include('essentials::settings.partials.attendance_settings')
                        </div>

                    </div>
                @endcomponent
            </div>



            <!--  </pos-tab-container> -->
        </div>
        </div>
    <!--
     <div class="row">
                <div class="col-xs-12">
                    <div class="form-group text-center">
                        {{ Form::submit(__('messages.update'), ['class' => 'tw-dw-btn tw-dw-btn-error tw-text-white']) }}
                    </div>
                </div>
            </div>
    -->

        {!! Form::close() !!}
        <div class="col-xs-12">
            <p class="help-block"><i>{!! __('essentials::lang.version_info', ['version' => $module_version]) !!}</i></p>
        </div>
    </section>
@stop
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea#leave_instructions',
            });

            $('#essentials_settings_form').validate({
                ignore: [],
            });
        });
    </script>
@endsection


