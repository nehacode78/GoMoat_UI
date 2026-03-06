@extends('layouts.app')

@section('title', __('crm::lang.campaigns'))

@section('content')
@include('crm::layouts.nav')
<!-- Content Header (Page header) -->

<!--
    <section class="content-header no-print">
       <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('crm::lang.campaigns')</h1>
    </section>
    -->

<section class="content no-print">
	@component('components.filters', ['title' => __('report.filters')])
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('campaign_type', __('crm::lang.campaign_type') . ':') !!}
                    {!! Form::select('campaign_type', ['sms' => __('crm::lang.sms'), 'email' => __('business.email')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'campaign_type_filter', 'placeholder' => __('messages.all')]); !!}
                </div>    
            </div>
        </div>
    @endcomponent
	@component('components.widget', ['class' => 'box-primary', 'title' => __('crm::lang.all_campaigns')])
        @slot('tool')
        	<div class="box-tools">
                <a href="{{action([\Modules\Crm\Http\Controllers\CampaignController::class, 'create'])}}"
                   class="tw-m-2 tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <path d="M12 5l0 14"/>
                        <path d="M5 12l14 0"/>
                    </svg>

                    Add Campaign
                </a>
            </div>
        @endslot
        <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="campaigns_table">
		        <thead>
		            <tr>
		                <th> @lang('messages.action')</th>
		                <th>@lang('crm::lang.campaign_name')</th>
		                <th>@lang('crm::lang.campaign_type')</th>
		                <th>@lang('business.created_by')</th>
                        <th>@lang('lang_v1.created_at')</th>
		            </tr>
		        </thead>
		    </table>
        </div>
    @endcomponent
    <div class="modal fade campaign_modal" tabindex="-1" role="dialog"></div>
    <div class="modal fade campaign_view_modal" tabindex="-1" role="dialog"></div>
</section>
@endsection


@section('javascript')
	<script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
// 			initializeCampaignDatatable();


			let campaigns_table = $('#campaigns_table').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: '/crm/campaigns',

                    buttons: [
                        { extend: 'csv', className:'campaign-buttons-csv' },
                        { extend: 'excel', className:'campaign-buttons-excel' },
                        { extend: 'pdf', className:'campaign-buttons-pdf' }
                    ],

                    columns: [
                        { data: 'action', name: 'action' },
                        { data: 'name', name: 'name' },
                        { data: 'campaign_type', name: 'campaign_type' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'created_at', name: 'created_at' }
                    ]
                });

                let campaignExportHtml = `
                <div class="tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom:10px">

                    <div class="tw-flex tw-items-center tw-gap-2">
                        <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center">
                            <i class="fas fa-file-csv tw-text-[11px]"></i>
                        </div>

                        <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center">
                            <i class="fas fa-file-excel tw-text-[11px]"></i>
                        </div>
                    </div>

                    <span>Export:</span>

                    <a href="#" id="campaign_export_csv" class="tw-text-blue-600 hover:tw-underline">CSV</a>
                    <a href="#" id="campaign_export_xls" class="tw-text-blue-600 hover:tw-underline">XLS</a>
                    <a href="#" id="campaign_export_pdf" class="tw-text-blue-600 hover:tw-underline">PDF</a>

                </div>
                `;

                $('#campaigns_table').closest('.dataTables_wrapper').append(campaignExportHtml);


                $(document).on('click','#campaign_export_csv',function(e){
                    e.preventDefault();
                    campaigns_table.button('.campaign-buttons-csv').trigger();
                });

                $(document).on('click','#campaign_export_xls',function(e){
                    e.preventDefault();
                    campaigns_table.button('.campaign-buttons-excel').trigger();
                });

                $(document).on('click','#campaign_export_pdf',function(e){
                    e.preventDefault();
                    campaigns_table.button('.campaign-buttons-pdf').trigger();
                });
		});
	</script>
@endsection

<style>
     .tw-bg-gradient-to-r{
        background:#2B7ADA !important;
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




    .sorting_disabled{
    color:#969696 !important;
    font-size:11px !important;
    font-family: Roboto !important;
    font-weight:700 !important;
    text-transform: uppercase;

    }

    .sorting{
    color:#969696 !important;
    font-size:11px !important;
    font-family: Roboto !important;
    font-weight:700 !important;
    text-transform: uppercase;

    }
    .sorting_desc{
    color:#969696 !important;
    font-size:11px !important;
    font-family: Roboto !important;
    font-weight:700 !important;
    text-transform: uppercase;
    }

    .sorting_asc{
    color:#969696 !important;
    font-size:11px !important;
    font-family: Roboto !important;
    font-weight:700 !important;
    text-transform: uppercase;
    }

    </style>