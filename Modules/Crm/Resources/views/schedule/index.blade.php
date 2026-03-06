@extends('layouts.app')
@section('title', __('crm::lang.follow_ups'))
@section('content')
	@include('crm::layouts.nav')
	<!-- Content Header (Page header) -->
	<!--
	<section class="content-header no-print">
    	   <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('crm::lang.follow_ups')</h1>
    	</section>
	-->
	<section class="content no-print">
		@component('components.filters', ['title' => __('report.filters')])
	        <div class="row">
	            <div class="col-md-4">
	                <div class="form-group">
	                    {!! Form::label('contact_id_filter', __('contact.contact') . ':') !!}
	                    {!! Form::select('contact_id_filter', $contacts, null, ['class' => 'form-control select2', 'form-control select2', 'style' => 'width: 100%;', 'id' => 'contact_id_filter', 'placeholder' => __('messages.all')]); !!}
	                </div>    
	            </div>
	            @if(auth()->user()->can('crm.access_all_schedule'))
		            <div class="col-md-4">
		                <div class="form-group">
		                    {!! Form::label('assgined_to_filter', __('crm::lang.assgined') . ':') !!}
		                    {!! Form::select('assgined_to_filter', $assigned_to, $default_user, ['class' => 'form-control select2', 'form-control select2', 'style' => 'width: 100%;', 'id' => 'assgined_to_filter', 'placeholder' => __('messages.all')]); !!}
		                </div>    
		            </div>

		        @endif
	            <div class="col-md-4">
	                <div class="form-group">
	                    {!! Form::label('status_filter', __('sale.status') . ':') !!}
	                    {!! Form::select('status_filter', $statuses, $default_status, ['class' => 'form-control select2', 'form-control select2', 'style' => 'width: 100%;', 'id' => 'status_filter', 'placeholder' => __('messages.all')]); !!}
	                </div>    
	            </div>
	            <div class="clearfix">
	            </div>
	            <div class="col-md-3">
	                <div class="form-group">
	                    {!! Form::label('schedule_type_filter', __('crm::lang.schedule_type') . ':') !!}
	                    {!! Form::select('schedule_type_filter', $follow_up_types, null, ['class' => 'form-control select2', 'form-control select2','style' => 'width: 100%;', 'id' => 'schedule_type_filter', 'placeholder' => __('messages.all')]); !!}
	                </div>    	
	            </div>
	            <div class="col-md-3">
	            	<div class="form-group">
	            		{!! Form::label('follow_up_date_range', __('report.date_range') . ':') !!}
	            		{!! Form::text('follow_up_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
	            	</div>
	            </div>
	            <div class="col-md-3">
	                <div class="form-group">
	                    {!! Form::label('follow_up_by_filter', __('crm::lang.follow_up_by') . ':') !!}
	                    {!! Form::select('follow_up_by_filter', ['payment_status' => __('sale.payment_status'), 'orders' => __('restaurant.orders')], null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'follow_up_by_filter', 'placeholder' => __('messages.all')]); !!}
	                </div>    
	            </div>
	            <div class="col-md-3">
	                <div class="form-group">
	                    {!! Form::label('followup_category_id_filter', __('crm::lang.followup_category') . ':') !!}
	                    {!! Form::select('followup_category_id_filter', $followup_category, $default_followup_category_id, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'form-control select2', 'id' => 'followup_category_id_filter', 'placeholder' => __('messages.all')]); !!}
	                </div>    
	            </div>
	        </div>
	    @endcomponent

	     <ul class="crm-tabs">

            <li class="active">
                <a href="#all_followup_tab" data-toggle="tab">ALL FOLLOW UPS</a>
            </li>

            <li>
                <a href="#recur_followup_tab" data-toggle="tab">RECURRING FOLLOW UP</a>
            </li>

            <li>
                <a href="#followup_category_tab" data-toggle="tab">FOLLOW UP CATEGORIES
                    </a>
            </li>

            <!--
              @lang('crm::lang.followup_category')
            -->



         </ul>

		<div class="row">
			<div class="col-md-12">
                    @component('components.widget', ['class' => 'box box-solid'])
                    @slot('title')
                    <span id="followup_table_title">All Follow Ups</span>
                    @endslot
                    @slot('tool')
			            <div class="box-tools">

                            <!--
                            <button type="button" class="tw-m-2 tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right btn-add-schedule">
                            							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            								stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            								class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            								<path d="M12 5l0 14" />
                            								<path d="M5 12l14 0" />
                            							</svg> @lang('messages.add')
                            						</button>
                            -->


                    <button type="button"
                            id="followup_action_btn"
                            class="tw-m-2 tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right btn-add-schedule">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        								stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        								class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        								<path d="M12 5l0 14" />
                        								<path d="M5 12l14 0" />
                        							</svg>
                        <span id="followup_action_text">Create Follow Up</span>

                    </button>
						<!--
						<button type="button" data-toggle="modal" data-target="#advance_followup_modal" class=" tw-m-2 tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right">
                        							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        								stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        								class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        								<path d="M12 5l0 14" />
                        								<path d="M5 12l14 0" />
                        							</svg>  @lang('crm::lang.add_advance_follow_up')
                        						</button>
						-->
			            </div>
			            <input type="hidden" name="schedule_create_url" id="schedule_create_url" value="{{action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'create'])}}">
		        	@endslot
			        <div class="col-sm-12">
			        	<div class="nav-tabs-custom">


			                <div class="tab-content">
                    			<div class="tab-pane active" id="all_followup_tab">
                    				<div class="table-responsive">
						            	<table class="table table-bordered table-striped" id="follow_up_table" style="width: 100%">
									        <thead>
									            <tr>
									            	<th>@lang('messages.action')</th>
									            	<th>
									            		@lang('contact.contact')
									            	</th>
									            	<th>@lang('crm::lang.start_datetime')</th>
									                <th>@lang('crm::lang.end_datetime')</th>
									                <th>@lang('sale.status')</th>
									                <th>@lang('crm::lang.schedule_type')</th>
									                <th>@lang('crm::lang.followup_category')</th>
									                <th>@lang('lang_v1.assigned_to')</th>
									                <th>
									                	@lang('crm::lang.description')
									                </th>
									                <th>
									                	@lang('crm::lang.additional_info')
									                </th>
									                <th>@lang('crm::lang.title')</th>
									                <th>
									                	@lang('lang_v1.added_by')
									                </th>
									                <th>
									                	@lang('lang_v1.added_on')
									                </th>
									            </tr>
									        </thead>
									        <tbody></tbody>
									        <tfoot>
			                                    <tr class="bg-gray font-17 footer-total text-center">
			                                        <td colspan="5">
			                                            <strong>@lang('sale.total'):</strong>
			                                        </td>
			                                        <td class="footer_follow_up_status_count"></td>
			                                        <td class="footer_follow_up_type_count"></td>
			                                        <td colspan="6"></td>
			                                    </tr>
			                                </tfoot>
									    </table>
						            </div>
                    			</div>
                    			<div class="tab-pane" id="recur_followup_tab">
                    				<div class="table-responsive">
						            	<table class="table table-bordered table-striped" id="recursive_follow_up_table" style="width: 100%">
									        <thead>
									            <tr>
									            	<th>@lang('messages.action')</th>
									                <th>@lang('sale.status')</th>
									                <th>@lang('crm::lang.schedule_type')</th>
									                <th>@lang('crm::lang.followup_category')</th>
									                <th>@lang('crm::lang.follow_up_by')</th>
									                <th>@lang('crm::lang.in_days')</th>
									                <th>@lang('lang_v1.assigned_to')</th>
									                <th>
									                	@lang('crm::lang.description')
									                </th>
									                <th>
									                	@lang('crm::lang.additional_info')
									                </th>
									                <th>@lang('crm::lang.title')</th>
									                <th>
									                	@lang('lang_v1.added_by')
									                </th>
									                <th>
									                	@lang('lang_v1.added_on')
									                </th>
									            </tr>
									        </thead>
									    </table>
						            </div>
                    			</div>

                           <div class="tab-pane" id="followup_category_tab">
                               <div class="table-responsive">
                                   <table class="table table-bordered table-striped"
                                          id="followup_category_table"
                                          style="width: 100%">
                                       <thead>
                                           <tr>
                                                <th>@lang('crm::lang.followup_category')</th>

                                              <th>@lang('crm::lang.description')</th>
                                              <th>@lang('messages.action')</th>
                                           </tr>
                                       </thead>
                                       <tbody></tbody>
                                   </table>
                               </div>
                           </div>

                    		</div>
			            </div>
			        </div>
		    	@endcomponent
			</div>
		</div>
	</section>
	<div class="modal fade schedule" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    <div class="modal fade edit_schedule" tabindex="-1" role="dialog"></div>

	<div class="modal fade schedule_log_modal" tabindex="-1" role="dialog"></div>

    @include('crm::schedule.partial.advance_followup_modal')
@endsection
@section('javascript')
	<script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
	<script type="text/javascript">
		$(function () {
			$('#follow_up_date_range').daterangepicker(
		        dateRangeSettings,
		        function (start, end) {
		            $('#follow_up_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
		            follow_up_datatable.ajax.reload();
		        }
		    );
		    $('#follow_up_date_range').on('cancel.daterangepicker', function(ev, picker) {
		        $('#follow_up_date_range').val('');
		        follow_up_datatable.ajax.reload();
		    });
		    $('#followup_category_id_filter').change(function(){
		    	follow_up_datatable.ajax.reload();
		    })

		    follow_up_datatable = $("#follow_up_table").DataTable({
				processing: true,
		        serverSide: true,
		        scrollY: "80vh",
				scrollX: true,
				scrollCollapse: true,


				 buttons: [
                        { extend: 'csv', className:'buttons-csv' },
                        { extend: 'excel', className:'buttons-excel' },
                        { extend: 'pdf', className:'buttons-pdf' }
                    ],


		        ajax: {
		            url: "/crm/follow-ups",
		            data:function(d) {
		            	d.contact_id = $("#contact_id_filter").val();
		            	d.assgined_to = $("#assgined_to_filter").val();
		            	d.status = $("#status_filter").val();
		            	d.schedule_type = $("#schedule_type_filter").val();
		            	d.follow_up_by = $("#follow_up_by_filter").val();
		            	d.followup_category_id = $("#followup_category_id_filter").val();

		            	if ($('#follow_up_date_range').val()) {
		            		d.start_date_time = $('#follow_up_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
		            		d.end_date_time = $('#follow_up_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
		            	}
		            }
		        },
		        columnDefs: [
		            {
		                targets: [0, 7, 9],
		                orderable: false,
		                searchable: false,
		            },
		        ],
		        aaSorting: [[2, 'desc']],
		        columns: [
		        	{ data: 'action', name: 'action' },
		        	{ data: 'contact', name: 'contacts.name' },
		        	{ data: 'start_datetime', name: 'start_datetime' },
		            { data: 'end_datetime', name: 'end_datetime' },
		            { data: 'status', name: 'crm_schedules.status' },
		            { data: 'schedule_type', name: 'schedule_type' },
		            { data: 'followup_category', name: 'C.name' },
		            { data: 'users', name: 'users' },
		            { data: 'description', name: 'description'},
		            { data: 'additional_info', name: 'additional_info' },
		            { data: 'title', name: 'title' },
		            { data: 'added_by', name: 'added_by' },
		            { data: 'added_on', name: 'crm_schedules.created_at' },
		        ],
		        "fnDrawCallback": function( oSettings ) {
		        	__show_date_diff_for_human($("#follow_up_table"));

		        	$('a.view_schedule_log').click(function(){
		        		getScheduleLog($(this).data('schedule_id'), true);
		        	})
			    },
		        "footerCallback": function ( row, data, start, end, display ) {
		        	$('.footer_follow_up_status_count').html(__count_status(data, 'status'));
		            $('.footer_follow_up_type_count').html(__count_status(data, 'schedule_type'));
		        }
			});

			let exportHtml = `
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

                <a href="#" id="export_csv" class="tw-text-blue-600 hover:tw-underline">CSV</a>
                <a href="#" id="export_xls" class="tw-text-blue-600 hover:tw-underline">XLS</a>
                <a href="#" id="export_pdf" class="tw-text-blue-600 hover:tw-underline">PDF</a>
            </div>
            `;

            $('#follow_up_table').closest('.dataTables_wrapper').append(exportHtml);


            $(document).on('click', '#export_csv', function(e){
                e.preventDefault();
                follow_up_datatable.button('.buttons-csv').trigger();
            });

            $(document).on('click', '#export_xls', function(e){
                e.preventDefault();
                follow_up_datatable.button('.buttons-excel').trigger();
            });

            $(document).on('click', '#export_pdf', function(e){
                e.preventDefault();
                follow_up_datatable.button('.buttons-pdf').trigger();
            });

			recursive_follow_up_table = $("#recursive_follow_up_table").DataTable({
				processing: true,
		        serverSide: true,
				scrollX: true,

				buttons: [
                 { extend:'csv', className:'recur-buttons-csv'},
                 { extend:'excel', className:'recur-buttons-excel'},
                 { extend:'pdf', className:'recur-buttons-pdf'}
                ],
		        ajax: {
		            url: "/crm/follow-ups",
		            data:function(d) {
		            	d.assgined_to = $("#assgined_to_filter").val();
		            	d.is_recursive = 1;
		            }
		        },
		        columnDefs: [
		            {
		                targets: [0, 6],
		                orderable: false,
		                searchable: false,
		            },
		        ],
		        aaSorting: [[2, 'desc']],
		        columns: [
		        	{ data: 'action', name: 'action' },
		            { data: 'status', name: 'crm_schedules.status' },
		            { data: 'schedule_type', name: 'schedule_type' },
		            { data: 'followup_category', name: 'C.name' },
		            { data: 'follow_up_by', name: 'crm_schedules.follow_up_by' },
		            { data: 'recursion_days', name: 'crm_schedules.recursion_days' },
		            { data: 'users', name: 'users' },
		            { data: 'description', name: 'description'},
		            { data: 'additional_info', name: 'additional_info' },
		            { data: 'title', name: 'title' },
		            { data: 'added_by', name: 'added_by' },
		            { data: 'added_on', name: 'crm_schedules.created_at' },
		        ]
			});


			let recurExportHtml = `
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

                <a href="#" id="recur_export_csv" class="tw-text-blue-600 hover:tw-underline">CSV</a>
                <a href="#" id="recur_export_xls" class="tw-text-blue-600 hover:tw-underline">XLS</a>
                <a href="#" id="recur_export_pdf" class="tw-text-blue-600 hover:tw-underline">PDF</a>
            </div>
            `;

            $('#recursive_follow_up_table').closest('.dataTables_wrapper').append(recurExportHtml);

            $(document).on('click','#recur_export_csv',function(e){
                e.preventDefault();
                recursive_follow_up_table.button('.recur-buttons-csv').trigger();
            });

            $(document).on('click','#recur_export_xls',function(e){
                e.preventDefault();
                recursive_follow_up_table.button('.recur-buttons-excel').trigger();
            });

            $(document).on('click','#recur_export_pdf',function(e){
                e.preventDefault();
                recursive_follow_up_table.button('.recur-buttons-pdf').trigger();
            });

			var followup_category_table;

            $('a[href="#followup_category_tab"]').on('shown.bs.tab', function () {

                if (!$.fn.DataTable.isDataTable('#followup_category_table')) {

                    followup_category_table = $("#followup_category_table").DataTable({
                        processing: true,
                        serverSide: true,

                        buttons:[
                         { extend:'csv', className:'cat-buttons-csv'},
                         { extend:'excel', className:'cat-buttons-excel'},
                         { extend:'pdf', className:'cat-buttons-pdf'}
                        ],

                        ajax: {
                            url: "{{ action([\App\Http\Controllers\TaxonomyController::class, 'index']) }}",
                            data: function (d) {
                                d.type = 'followup_category';
                            }
                        },
                        columnDefs: [
                            {
                                targets: 0,
                                orderable: false,
                                searchable: false,
                            }
                        ],
                        columns: [
                            { data: 'action', name: 'action' },
                            { data: 'name', name: 'name' },
                            { data: 'description', name: 'description' }
                        ]
                    });

                }

            });

            let categoryExportHtml = `
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

                <a href="#" id="cat_export_csv" class="tw-text-blue-600 hover:tw-underline">CSV</a>
                <a href="#" id="cat_export_xls" class="tw-text-blue-600 hover:tw-underline">XLS</a>
                <a href="#" id="cat_export_pdf" class="tw-text-blue-600 hover:tw-underline">PDF</a>
            </div>
            `;

            $('#followup_category_table').closest('.dataTables_wrapper').append(categoryExportHtml);

            $(document).on('click','#cat_export_csv',function(e){
                e.preventDefault();
                followup_category_table.button('.cat-buttons-csv').trigger();
            });

            $(document).on('click','#cat_export_xls',function(e){
                e.preventDefault();
                followup_category_table.button('.cat-buttons-excel').trigger();
            });

            $(document).on('click','#cat_export_pdf',function(e){
                e.preventDefault();
                followup_category_table.button('.cat-buttons-pdf').trigger();
            });

            $('.crm-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                var tab = $(e.target).attr('href');

                if(tab === '#all_followup_tab'){
                    $('#followup_table_title').text('All Follow Ups');
                    $('#followup_action_text').text('Create Follow Up');
                }

                if(tab === '#recur_followup_tab'){
                    $('#followup_table_title').text('Recurring Follow Ups');
                    $('#followup_action_text').text('Create Recurring Follow Up');
                }

                if(tab === '#followup_category_tab'){
                    $('#followup_table_title').text('Follow Up Categories');
                    $('#followup_action_text').text('Create Follow Up Category');
                }

            });

			$(document).on('change', '#contact_id_filter, #assgined_to_filter, #status_filter, #schedule_type_filter, #follow_up_by_filter', function() {
			    follow_up_datatable.ajax.reload();
			});
			
			// Set default date from get parameter
	        @if(!empty($default_start_date) && !empty($default_end_date))
	            $('#follow_up_date_range').val({{$default_start_date . ' - ' . $default_end_date}});
	            $('#follow_up_date_range').data('daterangepicker').setStartDate('{{$default_start_date}}');
	            $('#follow_up_date_range').data('daterangepicker').setEndDate('{{$default_end_date}}');
	            follow_up_datatable.ajax.reload();
	        @endif
		        
		});
	</script>
@endsection


<style>
    .tw-bg-gradient-to-r{
    background:#2B7ADA !important;
    }

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

    </style>

<style>

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


.nav-tabs-custom>.tab-content{
background:#F7F7F7 !important;
}



.sorting_disabled{
color:#969696 !important;
font-size:11px !important;
font-family: Roboto !important;
font-weight:700 !important;
text-transform: uppercase;
font:bold;
}

.sorting{
color:#969696 !important;
font-size:11px !important;
font-family: Roboto !important;
font-weight:700 !important;
text-transform: uppercase;
font:bold;

}
.sorting_desc{
color:#969696 !important;
font-size:11px !important;
font-family: Roboto !important;
font-weight:700 !important;
text-transform: uppercase;
font:bold;

}
.sorting_asc{
color:#969696 !important;
font-size:11px !important;
font-family: Roboto !important;
font-weight:700 !important;
text-transform: uppercase;
font:bold;
}
    </style>