@extends('layouts.app')

@section('title', __('essentials::lang.memos'))

@section('content')
@include('essentials::layouts.nav_essentials')
<section class="content">

    <!--
    <h4 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">
    		@lang('essentials::lang.all_memos')
    		<small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold"> @lang('essentials::lang.manage_memos')</small>
    	</h4>
    -->

		<div class="box box-solid">
			<div class="box-header">
				<h4 class="box-title">@lang('essentials::lang.all_memos')</h4>
			<div class="box-tools pull-right">
				<button type="button" class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-righ add_memo">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
						stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<path d="M12 5l0 14" />
						<path d="M5 12l14 0" />
					</svg> Add Memos
				</button>
			</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(['url' => action([\Modules\Essentials\Http\Controllers\DocumentController::class, 'store']), 'id' => 'upload_document_form','files' => true, 'style' => 'display:none']) !!}
						<div class="row">
                            <div class="col-sm-12">
	                            <div class="col-sm-6">
	                                <div class="form-group">
                                   		{!! Form::label('name', __('essentials::lang.heading') . ":*") !!}

                                   		{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
	                                 </div>
	                            </div>
	                            <div class="clearfix"></div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    {!! Form::label('description', __('essentials::lang.description') . ":")!!}
	                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) !!}
	                                 </div>
	                            </div>
	                            <div class="clearfix"></div>
                        		<div class="col-sm-4">
                                	<button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-sm tw-text-white">
                                		@lang('essentials::lang.submit')
                                	</button>
                                	&nbsp;
									<button type="button" class="tw-dw-btn tw-dw-btn-error tw-dw-btn-sm tw-text-white cancel_btn">
										@lang('essentials::lang.cancel')
									</button>
                        		</div>
                            </div>
                        </div>
                        <br><hr>
					{!! Form::close() !!}
					</div>

				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
					<table class="table table-bordered table-striped documents">
						<thead>
							<tr>
								<th> @lang('essentials::lang.heading')</th>
								<th> @lang('essentials::lang.description')</th>
								<th> @lang('essentials::lang.created_at')</th>
								<th> @lang('essentials::lang.action')</th>
							</tr>
						</thead>
					</table>
				</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- document share model -->
	<div class="modal fade document" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"></div>
	<!-- memos view model -->
	<div class="modal fade memos" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"></div>
@endsection

@section('javascript')


<script type="text/javascript">
     function appendExportSection(tableId){

            let wrapper = $(tableId).closest('.dataTables_wrapper');

            if(wrapper.length === 0) return;

            if(wrapper.find('.crm-export-section').length) return;

            let exportHtml = `
            <div class="crm-export-section tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom:10px;">

                <div class="tw-flex tw-items-center tw-gap-2">
                    <div class="tw-w-6 tw-h-6 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                        <i class="fas fa-file-csv"></i>
                    </div>
                    <div class="tw-w-6 tw-h-6 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
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

	$(document).ready(function(){
		//dataTable(memos)
		var documents = $(".documents").DataTable({
            processing: true,
            fixedHeader:false,
            ajax: "/essentials/document"+'?type=memos',

            buttons: [
                { extend: 'csv', className: 'buttons-csv', exportOptions:{columns:':visible:not(:last-child)'} },
                { extend: 'excel', className: 'buttons-excel', exportOptions:{columns:':visible:not(:last-child)'} },
                { extend: 'pdf', className: 'buttons-pdf', exportOptions:{columns:':visible:not(:last-child)'} }
            ],

            columns: [
                {data: "name", name:"documents.name"},
                {data: "description", name:"documents.description"},
                {data: "created_at", name:"documents.created_at"},
                {data: "action", name:"action", orderable:false},
            ]
        });

        documents.on('init', function(){
            appendExportSection('.documents');
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

		//destroy a document
		$(document).on('click', '.delete_doc', function(){
			url = $(this).data("href");
			swal({
		      title: LANG.sure,
		      icon: "warning",
		      buttons: true,
		      dangerMode: true,
		    }).then((confirmed) => {
		        if (confirmed) {
		        $.ajax({
					method: "DELETE",
					url: url,
					dataType: "json",
					success: function(result)
					{
						if(result.success == true)
						{
							toastr.success(result.msg);
	                        documents.ajax.reload();
						} else {
							toastr.error(result.msg);
						}
					}
				});
			    }
		    });
		});

		//opening share_doc model
		$(document).on('click', '.share_doc', function(){
			var url = $(this).data('href')+'?type=memos';
			$.ajax({
				method: "GET",
				dataType: "html",
				url: url,
				success: function(result){
					$(".document").html(result).modal("show");
				}
			});
		});

		//sharing document(save in DB)
		$(document).on('submit', 'form#share_document_form', function(e){
			e.preventDefault();
			var url = $(this).attr("action");
			var data = $("form#share_document_form").serialize();
			$.ajax({
				method: "PUT",
				url: url,
				dataType: "json",
				data: data,
				success:function(result){
					if(result.success == true){
						$(".document").html(result).modal("hide");
						toastr.success(result.msg);
					} else {
						toastr.error(result.msg);
					}
				}
			});
		});

		//opening memos view model
		$(document).on('click', '.view_memos', function(){
			var url = $(this).data('href')+'?type=memos';
			$.ajax({
				method: "GET",
				dataType: "html",
				url: url,
				success: function(result){
					$(".memos").html(result).modal("show");
				}
			});
		});

		//show a hidden form on add_memo click
		$(document).on('click', '.add_memo', function(){
			$("form#upload_document_form").fadeIn();
		});

		//form cancel_btn
	    $(document).on('click', '.cancel_btn', function(){
	    	$("form#upload_document_form")[0].reset();
			$("form#upload_document_form").fadeOut();
	    });

	});

</script>
@endsection

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