@extends('layouts.app')
@section('title', __('crm::lang.proposals'))
@section('content')
	@include('crm::layouts.nav')
	<!-- Content Header (Page header) -->
	<!--
	<section class="content-header no-print">
    	   <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('crm::lang.proposals')</h1>
    	</section>
	-->

	<!-- Main content -->
	<section class="content">
        	<ul class="crm-tabs">

                            <li class="active">
                                <a href="#all_followup_tab" data-toggle="tab">ALL PROPOSALS</a>
                            </li>

                            <li>
                                <a href="#recur_followup_tab" data-toggle="tab">TEMPLATE</a>
                            </li>

                            <!--
                              @lang('crm::lang.followup_category')
                            -->

                         </ul>

		@component('components.widget', ['class' => 'box-solid'])
			@if(!empty($proposal_template) && auth()->user()->can('crm.access_proposal'))
		        @slot('tool')
		            <div class="box-tools">
		                <a class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm pull-right " href="{{action([\Modules\Crm\Http\Controllers\ProposalTemplateController::class, 'send'])}}">
		                	<i class="fas fa-paper-plane"></i> @lang('crm::lang.send')
		                </a>
		            </div>
		        @endslot

	        @endif
	       <div class="tab-content">

               <!-- ALL PROPOSALS TAB -->
               <div class="tab-pane active" id="all_followup_tab">
                   <div class="table-responsive">
                       <table class="table table-bordered table-striped" id="proposals" style="width: 100%;">
                           <thead>
                               <tr>
                                   <th>@lang('contact.contact')</th>
                                   <th>@lang('crm::lang.subject')</th>
                                   <th>@lang('crm::lang.sent_by')</th>
                                   <th>@lang('receipt.date')</th>
                                   <th>@lang('messages.action')</th>
                               </tr>
                           </thead>
                       </table>
                   </div>
               </div>

               <!-- TEMPLATE TAB -->
               <div class="tab-pane" id="recur_followup_tab">

                   <div class="proposal-template-card">

                       <div class="proposal-template-header">
                           <div class="template-title">
                               <i class="fas fa-file-alt"></i>
                               Proposal Template
                           </div>

                           <div class="template-actions">
                               <button class="btn btn-danger btn-sm">
                                   <i class="fas fa-trash"></i> Delete
                               </button>

                               <button class="btn btn-success btn-sm">
                                   <i class="fas fa-edit"></i> Edit
                               </button>

                               <button class="btn btn-primary btn-sm">
                                   <i class="fas fa-paper-plane"></i> Send
                               </button>
                           </div>
                       </div>


                       <div class="template-body">

                           <div class="template-row">
                               <div class="template-label">CC</div>
                               <div class="template-value">
                                   example1@email.com, example2@email.com
                               </div>
                           </div>

                           <div class="template-row">
                               <div class="template-label">BCC</div>
                               <div class="template-value">
                                   anotherexample@mail.com
                               </div>
                           </div>

                           <div class="template-row">
                               <div class="template-label">SUBJECT</div>
                               <div class="template-value">
                                   The spring sale campaign offer
                               </div>
                           </div>

                           <div class="template-row">
                               <div class="template-label">EMAIL BODY</div>
                               <div class="template-value">
                                   Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet
                                   Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet
                                   Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet
                               </div>
                           </div>

                           <div class="template-row">
                               <div class="template-label">ATTACHMENTS</div>

                               <div class="template-attachment">
                                   <i class="fas fa-paperclip"></i>
                                   Google_Maps_icon_(2020).svg.png
                               </div>
                           </div>

                       </div>

                   </div>

               </div>

           </div>
    	@endcomponent

	</section>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready( function(){
           proposals_table = $('#proposals').DataTable({


               processing: true,
               serverSide: true,

               ajax: {
                   url: "{{action([\Modules\Crm\Http\Controllers\ProposalController::class, 'index'])}}"
               },

               buttons: [
                   { extend: 'csv', className:'proposal-buttons-csv' },
                   { extend: 'excel', className:'proposal-buttons-excel' },
                   { extend: 'pdf', className:'proposal-buttons-pdf' }
               ],

               columnDefs: [
                   {
                       targets: 4,
                       orderable: false,
                       searchable: false,
                   },
               ],

               aaSorting: [[3, 'desc']],

               columns: [
                   { data: 'name', name: 'contacts.name'},
                   { data: 'subject', name: 'crm_proposals.subject'},
                   { data: 'sent_by_full_name', name: 'sent_by_full_name'},
                   { data: 'created_at', name: 'crm_proposals.created_at'},
                   { data: 'action', name: 'action' },
               ]
           });

           let proposalHeader = `
           <div class="proposal-header tw-flex tw-items-center tw-gap-2 tw-mb-3">

               <div class="tw-w-6 tw-h-6 tw-border tw-rounded tw-flex tw-items-center tw-justify-center">
                   <i class="fas fa-envelope tw-text-gray-500 tw-text-[12px]"></i>
               </div>

               <span class="tw-text-[14px] tw-font-semibold tw-text-gray-700">
                   All Proposals
               </span>

           </div>
           `;

           $('#proposals').closest('.dataTables_wrapper').prepend(proposalHeader);



           let proposalExportHtml = `
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

               <a href="#" id="proposal_export_csv" class="tw-text-blue-600 hover:tw-underline">CSV</a>
               <a href="#" id="proposal_export_xls" class="tw-text-blue-600 hover:tw-underline">XLS</a>
               <a href="#" id="proposal_export_pdf" class="tw-text-blue-600 hover:tw-underline">PDF</a>

           </div>
           `;

           $('#proposals').closest('.dataTables_wrapper').append(proposalExportHtml);




           $(document).on('click','#proposal_export_csv',function(e){
               e.preventDefault();
               proposals_table.button('.proposal-buttons-csv').trigger();
           });

           $(document).on('click','#proposal_export_xls',function(e){
               e.preventDefault();
               proposals_table.button('.proposal-buttons-excel').trigger();
           });

           $(document).on('click','#proposal_export_pdf',function(e){
               e.preventDefault();
               proposals_table.button('.proposal-buttons-pdf').trigger();
           });

            $(document).on('click', 'a.delete_attachment', function (e) {
                e.preventDefault();
                var url = $(this).data('href');
                var this_btn = $(this);
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((confirmed) => {
                    if (confirmed) {
                        $.ajax({
                            method: 'DELETE',
                            url: url,
                            dataType: 'json',
                            success: function(result) {
                                if(result.success == true){
                                    this_btn.closest('tr').remove();
                                    toastr.success(result.msg);
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });


            $('.crm-tabs a').click(function(e){

                e.preventDefault();

                $('.crm-tabs li').removeClass('active');
                $(this).parent().addClass('active');

                $('.tab-pane').removeClass('active');
                $($(this).attr('href')).addClass('active');

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
    </style>


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


.proposal-header{
   font-size: 16px;
    margin-bottom: 24px;

}

 </style>

 <style>

     .proposal-template-card{
         background:#F9FAFB;
         border:1px solid #E5E7EB;
         border-radius:8px;
         padding:20px;
     }

     .proposal-template-header{
         display:flex;
         justify-content:space-between;
         align-items:center;
         margin-bottom:20px;
     }

     .template-title{
         font-weight:600;
         font-size:16px;
         color:#374151;
         display:flex;
         gap:8px;
         align-items:center;
     }

     .template-actions button{
         margin-left:8px;
     }

     .template-body{
         background:white;
         border-radius:8px;
         padding:20px;
/*          border:1px solid #E5E7EB; */
     }

     .template-row{
         display:flex;
         padding:12px 0;
         border-bottom:1px solid #F3F4F6;
     }

     .template-label{
         width:140px;
         font-size:11px;
         font-weight:700;
         color:#2262AE;
         letter-spacing:.08em;
     }

     .template-value{
         flex:1;
         font-size:13px;
         color:#374151;
     }

     .template-attachment{
         background:#F3F4F6;
         padding:10px;
         border-radius:6px;
         font-size:12px;
         display:flex;
         gap:8px;
         align-items:center;
     }
     </style>