@extends('layouts.app')
@section('title', __('business.business_settings'))

@section('css')
<style>
/* LEFT MENU CARD */
.left-menu-card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

/* RESET DEFAULT THEME STYLES */
.pos-tab-menu .list-group-item {
    background: #ffffff !important;
    border: none !important;
    border-bottom: 1px solid #eef0f4 !important;
    color: #333 !important;
    font-weight: 500;
    padding: 12px 14px;
    transition: all 0.2s ease;
}

/* ACTIVE TAB — FORCE COLOR */
.pos-tab-menu .list-group-item.active,
.pos-tab-menu .list-group-item.active:hover,
.pos-tab-menu .list-group-item.active:focus {
    background-color: #19267a !important;
    color: #ffffff !important;
    font-weight: 600;
}

/* HOVER (ONLY NON-ACTIVE) */
.pos-tab-menu .list-group-item:not(.active):hover {
    background-color: #eef1ff !important;
    color: #19267a !important;
}

/* REMOVE OUTER WHITE CARD */
.pos-tab-container,
.pos-tab-container > .box-body {
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 !important;
}

/* REMOVE the big outer background / border wrapping BOTH cards */
.content > .row > .col-xs-12 > .box,
.content > .row > .col-xs-12 > .box-body,
.pos-tab-container {
    background: transparent !important;
    border: 0 !important;
    box-shadow: none !important;
}

/* REMOVE padding that creates fake border look */
.content {
    padding: 0 !important;
}

/* Ensure row has no background */
.content .row {
    background: transparent !important;
}

/* Keep ONLY left & right cards visible */
.left-menu-card,
.settings-card .box {
    background: #ffffff;
}

/* ===== SELECT2 DROPDOWN FIX ===== */

/* Dropdown container */
.select2-dropdown {
    background: #ffffff !important;
    border: 1px solid #dcdfe6 !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08) !important;
}

/* Search input inside dropdown */
.select2-search__field {
    background: #ffffff !important;
    color: #333 !important;
    border: 1px solid #dcdfe6 !important;
    border-radius: 6px !important;
    padding: 8px 10px !important;
}

/* Remove dark focus */
.select2-search__field:focus {
    outline: none !important;
    box-shadow: none !important;
    border-color: #19267a !important;
}

/* Dropdown options */
.select2-results__option {
    background: #ffffff !important;
    color: #333 !important;
}

/* Hover option */
.select2-results__option--highlighted {
    background-color: #eef1ff !important;
    color: #19267a !important;
}

/* Selected option */
.select2-results__option[aria-selected="true"] {
    background-color: #19267a !important;
    color: #ffffff !important;
}

/* Main select box */
.select2-container--default .select2-selection--single {
    background-color: #ffffff !important;
    border: 1px solid #dcdfe6 !important;
    height: 38px !important;
}

/* Remove dark arrow background */
.select2-selection__arrow {
    background: transparent !important;
}



/* ===== PLACEHOLDER FONT SIZE (EXTRA SMALL) ===== */

/* Normal inputs & textarea */

input::placeholder,
textarea::placeholder {
    font-size: 11px !important;
    color: #a0a4ab !important;
}

/* Browser support */
input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
    font-size: 11px !important;
}

input::-moz-placeholder,
textarea::-moz-placeholder {
    font-size: 11px !important;
}
.form-control{
font-size: 12px !important
}


/* ===== SELECT2 SEARCH PLACEHOLDER ===== */
.select2-search__field::placeholder {
    font-size: 11px !important;
    color: #a0a4ab !important;
}

.select2-search__field::-webkit-input-placeholder {
    font-size: 11px !important;
}

.select2-search__field::-moz-placeholder {
    font-size: 11px !important;
}




</style>
@endsection





@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-lg md:tw-text-2xl tw-font-semibold tw-text-black">@lang('business.business_settings')</h1>
    <br>
    @include('layouts.partials.search_settings')
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['url' => action([\App\Http\Controllers\BusinessController::class, 'postBusinessSettings']), 'method' => 'post', 'id' => 'bussiness_edit_form',
           'files' => true ]) !!}
    <div class="row">
        <div class="col-xs-12">
       <!--  <pos-tab-container> -->
        {{-- <div class="col-xs-12 pos-tab-container"> --}}
        @component('components.widget', ['class' =>  'pos-tab-container'])
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">


                <div class="left-menu-card">
                    <div class="pos-tab-menu">
                        <div class="list-group">

                            <a href="#" class="list-group-item text-center active" data-target="tab_business">
                                @lang('business.business')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_tax">
                                @lang('business.tax')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_product">
                                @lang('business.product')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_contact">
                                @lang('contact.contact')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_sale">
                                @lang('business.sale')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_pos">
                                @lang('sale.pos_sale')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_display">
                                @lang('lang_v1.display_screen')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_purchase">
                                @lang('purchase.purchases')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_payment">
                                @lang('lang_v1.payment')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_dashboard">
                                @lang('business.dashboard')
                            </a>

                            <a href="#" class="list-group-item text-center" data-target="tab_system">
                                @lang('business.system')
                            </a>

                        </div>
                    </div>
                </div>

            </div>


              <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">


                <div class="settings-card" id="tab_business">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.business')])
                        @include('business.partials.settings_business')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_tax">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.tax')])
                        @include('business.partials.settings_tax')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_product">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.product')])
                        @include('business.partials.settings_product')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_contact">
                    @component('components.widget',['class'=>'box-primary','title'=>__('contact.contact')])
                        @include('business.partials.settings_contact')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_sale">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.sale')])
                        @include('business.partials.settings_sales')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_pos">
                    @component('components.widget',['class'=>'box-primary','title'=>__('sale.pos_sale')])
                        @include('business.partials.settings_pos')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_display">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.display_screen')])
                        @include('business.partials.settings_display_pos')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_purchase">
                    @component('components.widget',['class'=>'box-primary','title'=>__('purchase.purchases')])
                        @include('business.partials.settings_purchase')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_payment">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.payment')])
                        @include('business.partials.settings_payment')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_dashboard">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.dashboard')])
                        @include('business.partials.settings_dashboard')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_system">
                    @component('components.widget',['class'=>'box-primary','title'=>__('business.system')])
                        @include('business.partials.settings_system')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_prefixes">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.prefixes')])
                        @include('business.partials.settings_prefixes')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_email">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.email_settings')])
                        @include('business.partials.settings_email')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_sms">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.sms_settings')])
                        @include('business.partials.settings_sms')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_reward">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.reward_point_settings')])
                        @include('business.partials.settings_reward_point')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_modules">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.modules')])
                        @include('business.partials.settings_modules')
                    @endcomponent
                </div>

                <div class="settings-card" id="tab_labels">
                    @component('components.widget',['class'=>'box-primary','title'=>__('lang_v1.custom_labels')])
                        @include('business.partials.settings_custom_labels')
                    @endcomponent
                </div>

            </div>

        @endcomponent
        {{-- </div> --}}
        <!--  </pos-tab-container> -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 text-center">
            <button class="tw-dw-btn btn-brand tw-dw-btn-md tw-text-white" type="submit">@lang('business.update_settings')</button>
        </div>
    </div>
{!! Form::close() !!}
</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    __page_leave_confirmation('#bussiness_edit_form');
    $(document).on('ifToggled', '#use_superadmin_settings', function() {
        if ($('#use_superadmin_settings').is(':checked')) {
            $('#toggle_visibility').addClass('hide');
            $('.test_email_btn').addClass('hide');
        } else {
            $('#toggle_visibility').removeClass('hide');
            $('.test_email_btn').removeClass('hide');
        }
    });

    $(document).ready(function(){

    $('.pos-tab-menu .list-group-item').on('click', function () {

        // Left active state
        $('.pos-tab-menu .list-group-item').removeClass('active');
        $(this).addClass('active');

        // Right card switching
        var target = $(this).data('target');
        $('.settings-card').hide();
        $('#' + target).fadeIn(150);
    });



        $('#test_email_btn').click( function() {
            var data = {
                mail_driver: $('#mail_driver').val(),
                mail_host: $('#mail_host').val(),
                mail_port: $('#mail_port').val(),
                mail_username: $('#mail_username').val(),
                mail_password: $('#mail_password').val(),
                mail_encryption: $('#mail_encryption').val(),
                mail_from_address: $('#mail_from_address').val(),
                mail_from_name: $('#mail_from_name').val(),
            };
            $.ajax({
                method: 'post',
                data: data,
                url: "{{ action([\App\Http\Controllers\BusinessController::class, 'testEmailConfiguration']) }}",
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        swal({
                            text: result.msg,
                            icon: 'success'
                        });
                    } else {
                        swal({
                            text: result.msg,
                            icon: 'error'
                        });
                    }
                },
            });
        });

        $('#test_sms_btn').click( function() {
            var test_number = $('#test_number').val();
            if (test_number.trim() == '') {
                toastr.error('{{__("lang_v1.test_number_is_required")}}');
                $('#test_number').focus();

                return false;
            }

            var data = {
                url: $('#sms_settings_url').val(),
                send_to_param_name: $('#send_to_param_name').val(),
                msg_param_name: $('#msg_param_name').val(),
                request_method: $('#request_method').val(),
                param_1: $('#sms_settings_param_key1').val(),
                param_2: $('#sms_settings_param_key2').val(),
                param_3: $('#sms_settings_param_key3').val(),
                param_4: $('#sms_settings_param_key4').val(),
                param_5: $('#sms_settings_param_key5').val(),
                param_6: $('#sms_settings_param_key6').val(),
                param_7: $('#sms_settings_param_key7').val(),
                param_8: $('#sms_settings_param_key8').val(),
                param_9: $('#sms_settings_param_key9').val(),
                param_10: $('#sms_settings_param_key10').val(),

                param_val_1: $('#sms_settings_param_val1').val(),
                param_val_2: $('#sms_settings_param_val2').val(),
                param_val_3: $('#sms_settings_param_val3').val(),
                param_val_4: $('#sms_settings_param_val4').val(),
                param_val_5: $('#sms_settings_param_val5').val(),
                param_val_6: $('#sms_settings_param_val6').val(),
                param_val_7: $('#sms_settings_param_val7').val(),
                param_val_8: $('#sms_settings_param_val8').val(),
                param_val_9: $('#sms_settings_param_val9').val(),
                param_val_10: $('#sms_settings_param_val10').val(),
                test_number: test_number,

                header_1: $('#sms_settings_header_key1').val(),
                header_val_1: $('#sms_settings_header_val1').val(),
                header_2: $('#sms_settings_header_key2').val(),
                header_val_2: $('#sms_settings_header_val2').val(),
                header_3: $('#sms_settings_header_key3').val(),
                header_val_3: $('#sms_settings_header_val3').val(),
                data_parameter_type: $('#data_parameter_type').val(),
            };

            $.ajax({
                method: 'post',
                data: data,
                url: "{{ action([\App\Http\Controllers\BusinessController::class, 'testSmsConfiguration']) }}",
                dataType: 'json',
                success: function(result) {
                    if (result.success == true) {
                        swal({
                            text: result.msg,
                            icon: 'success'
                        });
                    } else {
                        swal({
                            text: result.msg,
                            icon: 'error'
                        });
                    }
                },
            });

        });

        $('select.custom_labels_products').change(function(){
            value = $(this).val();
            textarea = $(this).parents('div.custom_label_product_div').find('div.custom_label_product_dropdown');
            if(value == 'dropdown'){
                textarea.removeClass('hide');
            } else{
                textarea.addClass('hide');
            }
        })

        tinymce.init({
            selector: 'textarea#display_screen_heading',
            height: 250
        });

        $('.carousel_image').fileinput({
            showUpload: true,
            showPreview: true,
            browseLabel: LANG.file_browse_label,
            removeLabel: LANG.remove,
        });
    });
</script>
@endsection