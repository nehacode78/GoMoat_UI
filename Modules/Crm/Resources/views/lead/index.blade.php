@extends('layouts.app')

@section('title', __('crm::lang.lead'))

@section('content')
@include('crm::layouts.nav')
<!-- Content Header (Page header) -->
<!--
    <section class="content-header no-print">
       <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('crm::lang.leads')</h1>
    </section>

    -->

<section class="content no-print">
    @component('components.filters', ['title' => __('report.filters')])
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('source', __('crm::lang.source') . ':') !!}
                    {!! Form::select('source', $sources, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'source', 'placeholder' => __('messages.all')]); !!}
                </div>    
            </div>
            @if($lead_view != 'kanban')
                <div class="col-md-4">
                    <div class="form-group">
                         {!! Form::label('life_stage', __('crm::lang.life_stage') . ':') !!}
                        {!! Form::select('life_stage', $life_stages, null, ['class' => 'form-control select2', 'id' => 'life_stage', 'style' => 'width:100%', 'placeholder' => __('messages.all')]); !!}
                    </div>
                </div>
            @endif
            @if(count($users) > 0)
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('user_id', __('lang_v1.assigned_to') . ':') !!}
                    {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'id' => 'user_id', 'style' => 'width:100%', 'placeholder' => __('messages.all')]); !!}
                </div>    
            </div>
            @endif
        </div>
    @endcomponent

     {{-- Toggle Tabs --}}
             <ul class="crm-tabs">
                 <li class="active">
                     <a href="#leads_tab" data-toggle="tab">LEADS</a>
                 </li>
                 <li>
                     <a href="#sources_tab" data-toggle="tab">SOURCES</a>
                 </li>
                 <li>
                     <a href="#life_stage_tab" data-toggle="tab">LIFE STAGE</a>
                 </li>
             </ul>
    
	@component('components.widget', ['class' => 'box-primary'])
    @slot('title')
    <span id="crm_table_title">@lang('crm::lang.all_leads')</span>
    @endslot
      @slot('tool')
      <div class="tw-flex tw-items-center tw-gap-3 pull-right m-5">

          {{-- Add Lead --}}
          <button type="button"
              id="add_lead_btn"
              class="tw-dw-btn tw-dw-btn-primarys tw-text-white tw-dw-btn-sm btn-add-lead"
              data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'create'])}}">
              <i class="fa fa-plus"></i> Add Lead
          </button>

          {{-- Add Source --}}
          <button type="button"
              id="add_source_btn"
              class="tw-dw-btn tw-dw-btn-primarys tw-text-white tw-dw-btn-sm"
              style="display:none;">
              <i class="fa fa-plus"></i> Add Source
          </button>

          {{-- Add Life Stage --}}
          <button type="button"
              id="add_life_stage_btn"
              class="tw-dw-btn tw-dw-btn-primarys tw-text-white tw-dw-btn-sm"
              style="display:none;">
              <i class="fa fa-plus"></i> Add Life Stage
          </button>

      </div>

      @endslot




        <div class="tab-content">

            {{-- ================= LEADS TAB ================= --}}
            <div class="tab-pane active" id="leads_tab">

                <div class="crm-toolbar">
                    <div class="crm-left-tools">
                        <div id="lead_view_toggle" class="btn-group btn-group-toggle crm-view-toggle"  data-toggle="buttons">
                            <label class="btn btn-info btn-sm list" style="padding-left:20px;">
                                <input type="radio" name="lead_view" value="list_view"
                                       class="lead_view"
                                       data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'index']).'?lead_view=list_view'}}">
                                LIST
                            </label>

                            <label class="btn btn-info btn-sm kanban">
                                <input type="radio" name="lead_view" value="kanban"
                                       class="lead_view"
                                       data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'index']).'?lead_view=kanban'}}">
                                KANBAN
                            </label>
                        </div>
                    </div>
                </div>



                 @if($lead_view == 'list_view')
                       	<table class="table table-bordered table-striped" id="leads_table">
               		        <thead>
               		            <tr>
               		                <th>@lang('messages.action')</th>
               		                <th>@lang('lang_v1.contact_id')</th>
               		                <th>@lang('contact.name')</th>
                                       <th>@lang('contact.mobile')</th>
                                       <th>@lang('business.email')</th>
                                       <th>@lang('crm::lang.source')</th>
                                       <th style="width: 200px !important">
                                           @lang('crm::lang.last_follow_up')
                                       </th>
                                       <th style="width: 200px !important">
                                           @lang('crm::lang.upcoming_follow_up')
                                       </th>
                                       <th>@lang('crm::lang.life_stage')</th>
                                       <th>@lang('lang_v1.assigned_to')</th>
                                       <th>@lang('business.address')</th>
                                       <th>@lang('contact.tax_no')</th>
                                       <th>@lang('lang_v1.added_on')</th>
                                       @php
                                           $custom_labels = json_decode(session('business.custom_labels'), true);
                                       @endphp
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_5'] ?? __('lang_v1.custom_field', ['number' => 5]) }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_6'] ?? __('lang_v1.custom_field', ['number' => 6]) }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_7'] ?? __('lang_v1.custom_field', ['number' => 7]) }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_8'] ?? __('lang_v1.custom_field', ['number' => 8]) }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_9'] ?? __('lang_v1.custom_field', ['number' => 9]) }}
                                       </th>
                                       <th>
                                           {{ $custom_labels['contact']['custom_field_10'] ?? __('lang_v1.custom_field', ['number' => 10]) }}
                                       </th>
               		            </tr>
               		        </thead>
                               <tfoot>
                                   <!-- Code commented temporarily as no relevant codes found -->
                                   <!-- <tr class="bg-gray font-17 text-center footer-total">
                                       <td colspan="23" class="text-left">
                                           <button type="button" class="btn btn-xs btn-success update_contact_location" data-type="add">@lang('lang_v1.add_to_location')</button>
                                               &nbsp;
                                               <button type="button" class="btn btn-xs bg-navy update_contact_location" data-type="remove">@lang('lang_v1.remove_from_location')</button>
                                       </td>
                                   </tr> -->
                               </tfoot>
               		    </table>
                       @endif


               @if($lead_view == 'kanban')
                           <div class="lead-kanban-board">
                               <div class="page">
                                   <div class="main">
                                       <div class="meta-tasks-wrapper">
                                           <div id="myKanban" class="meta-tasks">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       @endif

            </div>

        {{-- ================= SOURCES TAB ================= --}}
        <div class="tab-pane" id="sources_tab">
            <table class="table table-bordered table-striped" id="lead_sources_table">
                <thead>
                    <tr>
                        <th>@lang('crm::lang.source')</th>
                        <th>@lang('crm::lang.description')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
            </table>
        </div>

        {{-- ================= LIFE STAGE TAB ================= --}}
        <div class="tab-pane" id="life_stage_tab">
            <table class="table table-bordered table-striped" id="life_stage_table">
                <thead>
                    <tr>
                        <th>@lang('crm::lang.life_stage')</th>
                        <th>@lang('crm::lang.description')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
            </table>
        </div>


    @endcomponent
    <div class="modal fade contact_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade schedule" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
</section>
@endsection
@section('javascript')
	<script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">

        function appendExportSection(tableId){

                    let wrapper = $(tableId).closest('.dataTables_wrapper');

                    if(wrapper.length === 0) return;

                    if(wrapper.find('.crm-export-section').length) return;

                    let exportHtml = `
                    <div class="crm-export-section tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom:10px;">
                        <div class="tw-flex tw-items-center tw-gap-2">
                            <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                                <i class="fas fa-file-csv"></i>
                            </div>
                            <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                                <i class="fas fa-file-excel"></i>
                            </div>
                        </div>

                        <span>Export:</span>

                        <a href="#" class="export-csv">CSV</a>
                        <a href="#" class="export-xls">XLS</a>
                        <a href="#" class="export-pdf">PDF</a>
                    </div>
                    `;

                    wrapper.append(exportHtml);
                }

            setTimeout(function(){
                appendExportSection('#leads_table');
            },1000);

        $(document).ready(function() {

            var lead_view = urlSearchParam('lead_view');

            if (_.isEmpty(lead_view)) {
                lead_view = 'list_view';
            }

            if (lead_view == 'kanban') {
                $('.kanban').addClass('active');
                $('.list').removeClass('active');
                initializeLeadKanbanBoard();
            } else if (lead_view == 'list_view') {
                initializeLeadDatatable();
            }

            // Move LIST/KANBAN beside "Show entries"
            setTimeout(function(){
                var viewButtons = $('#lead_view_toggle');
                $('.dataTables_length').prepend(viewButtons);
            }, 300);

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

      $('a[href="#sources_tab"]').on('shown.bs.tab', function () {

          if (!$.fn.DataTable.isDataTable('#lead_sources_table')) {

              let table = $('#lead_sources_table').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: {
                      url: "{{ action([\App\Http\Controllers\TaxonomyController::class, 'index']) }}",
                      data: function (d) {
                          d.type = 'lead_source';
                      }
                  },
                  columns: [
                      { data: 'name', name: 'name' },
                      { data: 'description', name: 'description' },
                      { data: 'action', name: 'action', orderable:false, searchable:false }
                  ]
              });

              table.on('init', function(){
                  appendExportSection('#lead_sources_table');
              });

          } else {
              appendExportSection('#lead_sources_table');
          }

      });




       $('a[href="#life_stage_tab"]').on('shown.bs.tab', function () {

           if (!$.fn.DataTable.isDataTable('#life_stage_table')) {

               let table = $('#life_stage_table').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax: {
                       url: "{{ action([\App\Http\Controllers\TaxonomyController::class, 'index']) }}",
                       data: function (d) {
                           d.type = 'lead_life_stage';
                       }
                   },
                   columns: [
                       { data: 'name', name: 'name' },
                       { data: 'description', name: 'description' },
                       { data: 'action', name: 'action', orderable:false, searchable:false }
                   ]
               });

               table.on('init', function(){
                   appendExportSection('#life_stage_table');
               });

           } else {
               appendExportSection('#life_stage_table');
           }

       });


        function toggleLeadViewButtons() {
            var activeTab = $('.crm-tabs li.active a').attr('href');

            if (activeTab === '#leads_tab') {
                $('#lead_view_toggle').show();
            } else {
                $('#lead_view_toggle').hide();
            }
        }


        function updateHeaderByTab(tab) {

            if(tab === '#leads_tab'){
                $('#crm_table_title').text('All Leads');

                $('#add_lead_btn').show();
                $('#add_source_btn').hide();
                $('#add_life_stage_btn').hide();
            }

            if(tab === '#sources_tab'){
                $('#crm_table_title').text('Sources');

                $('#add_lead_btn').hide();
                $('#add_source_btn').show();
                $('#add_life_stage_btn').hide();
            }

            if(tab === '#life_stage_tab'){
                $('#crm_table_title').text('Life Stage');

                $('#add_lead_btn').hide();
                $('#add_source_btn').hide();
                $('#add_life_stage_btn').show();
            }
        }

        $(document).ready(function(){

            // Default load
            updateHeaderByTab('#leads_tab');

            // Tab change
            $('.crm-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var tab = $(e.target).attr('href');
                updateHeaderByTab(tab);
            });

        });

        $(document).ready(function () {

            // On page load
            toggleLeadViewButtons();

            // On tab click
            $('.crm-tabs a[data-toggle="tab"]').on('shown.bs.tab', function () {
                toggleLeadViewButtons();
            });

        });


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
        font-size:12px;
        letter-spacing:.08em;
        font-weight:600;
        color:#9CA3AF;
        padding-bottom:10px;
        display:inline-block;
    }

    .crm-tabs li.active a{
        color:#16A34A;
        border-bottom:2px solid #16A34A;
    }


.crm-table-header{
    margin-bottom:15px;
}

/* Row 1 */
.crm-header-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

/* Row 2 */
.crm-toolbar-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* Left tools */
.crm-left-tools{
    display:flex;
    align-items:center;
    gap:15px;
}

/* Right tools */
.crm-right-tools{
    display:flex;
    align-items:center;
    gap:10px;
}

/* Title */
.crm-title{
    font-size:16px;
    font-weight:600;
    color:#374151;
    display:flex;
    align-items:center;
    gap:6px;
}

/* Toggle buttons */
.crm-view-toggle label{
    border-radius:6px;
    font-size:11px;
    padding:4px 10px;
}

.crm-view-toggle .btn-info{
    background:#2B7ADA;
    border-color:#2563EB;
}

/* Datatable search */
.dataTables_filter{
    margin:0;
}

.dataTables_filter input{
    border-radius:6px;
    border:1px solid #E5E7EB;
    padding:5px 8px;
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

.tw-dw-btn-primarys{
background:#2B7ADA !important;
border:none !important;
}
.tw-text-base{
font-size:16px !important;
color:#333333 !important;
}


#lead_view_toggle{
    margin-right: 12px;
}


    </style>