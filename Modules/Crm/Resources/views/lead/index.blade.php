@extends('layouts.app')

@section('title', __('crm::lang.lead'))

@section('content')
@include('crm::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header no-print">
   <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('crm::lang.leads')</h1>
</section>

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
    
	@component('components.widget', ['class' => 'box-primary', 'title' => __('crm::lang.all_leads')])
      @slot('tool')
      <div class="tw-flex tw-items-center tw-gap-3 pull-right m-5">

          {{-- Toggle Tabs --}}
          <ul class="nav nav-pills tw-m-0">
              <li class="active">
                  <a href="#leads_tab" data-toggle="tab">@lang('crm::lang.leads')</a>
              </li>
              <li>
                  <a href="#sources_tab" data-toggle="tab">@lang('crm::lang.sources')</a>
              </li>
              <li>
                  <a href="#life_stage_tab" data-toggle="tab">@lang('crm::lang.life_stages')</a>
              </li>
          </ul>

          {{-- Add Lead Button --}}

         <button type="button"
                      id="add_lead_btn"
                      class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm btn-add-lead"
                       data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'create'])}}">
                       <i class="fa fa-plus"></i> @lang('messages.add')
                 </button>


          {{-- List / Kanban Toggle (Only for Leads Tab) --}}
          <div id="lead_view_toggle" class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-info btn-sm active list">
                  <input type="radio" name="lead_view" value="list_view"
                         class="lead_view"
                         data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'index']).'?lead_view=list_view'}}">
                  @lang('crm::lang.list_view')
              </label>
              <label class="btn btn-info btn-sm kanban">
                  <input type="radio" name="lead_view" value="kanban"
                         class="lead_view"
                         data-href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'index']).'?lead_view=kanban'}}">
                  @lang('crm::lang.kanban_board')
              </label>
          </div>

      </div>
      @endslot




        <div class="tab-content">

            {{-- ================= LEADS TAB ================= --}}
            <div class="tab-pane active" id="leads_tab">

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
        $(document).ready(function() {
            var lead_view = urlSearchParam('lead_view');

            //if lead view is empty, set default to list_view
            if (_.isEmpty(lead_view)) {
                lead_view = 'list_view';
            }

            if (lead_view == 'kanban') {
                $('.kanban').addClass('active');
                $('.list').removeClass('active');
                initializeLeadKanbanBoard();
            } else if(lead_view == 'list_view') {
                initializeLeadDatatable();
            }
        });

        $('a[href="#sources_tab"]').on('shown.bs.tab', function () {

            if (!$.fn.DataTable.isDataTable('#lead_sources_table')) {

                $('#lead_sources_table').DataTable({
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
            }
        });


        $('a[href="#life_stage_tab"]').on('shown.bs.tab', function () {

            if (!$.fn.DataTable.isDataTable('#life_stage_table')) {

                $('#life_stage_table').DataTable({
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
            }
        });
        // Show / Hide List-Kanban Toggle Based On Tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

            var target = $(e.target).attr("href");

            if (target === '#leads_tab') {
                $('#lead_view_toggle').show();
            } else {
                $('#lead_view_toggle').hide();
            }
        });

        // Ensure correct state on page load
        $(document).ready(function () {

            var activeTab = $('.nav-pills li.active a').attr('href');

            if (activeTab !== '#leads_tab') {
                $('#lead_view_toggle').hide();
            }

        });



    </script>
@endsection