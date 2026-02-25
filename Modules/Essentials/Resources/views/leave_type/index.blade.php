@extends('layouts.app')
@section('title', __('essentials::lang.leave_type'))

@section('content')
@include('essentials::layouts.nav_hrm')
<!--
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('essentials::lang.leave_type')
        </h1>
    </section>
    -->
<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-solid', 'title' => __( 'essentials::lang.all_leave_types' )])
        @slot('tool')
            <div class="box-tools">
                <button type="button"
                    class="tw-bg-[#2B7ADA] hover:tw-bg-[#1f5bd8]
                           tw-text-white tw-border-none
                           tw-rounded-xl
                           tw-px-4 tw-py-2
                           tw-text-sm tw-font-medium
                           tw-flex tw-items-center tw-gap-2 btn-modal"
                    style="background-color: #2B7ADA !important;"
                    data-toggle="modal"
                    data-target="#add_leave_type_modal">

                    <i class="fas fa-plus tw-text-xs"></i>
                    Add Leave Type
                </button>
            </div>
        @endslot
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="leave_type_table">
                <thead>
                    <tr>
                        <th>@lang( 'essentials::lang.leave_type' )</th>
                        <th>@lang( 'essentials::lang.max_leave_count' )</th>
                        <th>@lang( 'messages.action' )</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    @include('essentials::leave_type.create')

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready( function(){

           leave_type_table = $('#leave_type_table').DataTable({
               processing: true,
               serverSide: true,
               fixedHeader: false,

               dom:
                   "<'tw-flex tw-justify-between tw-items-center tw-mb-4'<'tw-flex tw-items-center'l><'tw-flex tw-items-center tw-gap-3'f>>"
                   + "tr"
                   + "<'tw-flex tw-justify-between tw-items-center tw-mt-4'<'tw-text-sm'i><'tw-flex tw-items-center'p>>",

               ajax: "{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveTypeController::class, 'index'])}}",

               buttons: [
                   { extend: 'csv', text: 'CSV', className: 'tw-text-blue-600 tw-text-sm' },
                   { extend: 'excel', text: 'XLS', className: 'tw-text-blue-600 tw-text-sm' },
                   { extend: 'pdf', text: 'PDF', className: 'tw-text-blue-600 tw-text-sm' }
               ],

               columnDefs: [
                   {
                       targets: 2,
                       orderable: false,
                       searchable: false,
                   },
               ],

               columns: [
                   { data: 'leave_type', name: 'leave_type' },
                   { data: 'max_leave_count', name: 'max_leave_count' },
                   { data: 'action', name: 'action' }
               ]
           });

           let exportHtml = `
           <div class="tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom: 10px;">
               <div class="tw-flex tw-items-center tw-gap-2">
                   <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                       <i class="fas fa-file-csv tw-text-[11px]"></i>
                   </div>
                   <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                       <i class="fas fa-file-excel tw-text-[11px]"></i>
                   </div>
               </div>

               <span>Export:</span>

               <a href="#" class="tw-text-blue-600 hover:tw-underline">CSV</a>
               <a href="#" class="tw-text-blue-600 hover:tw-underline">XLS</a>
               <a href="#" class="tw-text-blue-600 hover:tw-underline">PDF</a>
           </div>
           `;

           $('#leave_type_table').closest('.dataTables_wrapper').append(exportHtml);

        });


        $('.filter-btn').html(`
                       <button id="openFilterModal"
                           class="tw-h-[44px] tw-border tw-border-gray-300 tw-bg-white hover:tw-bg-gray-50
                           tw-rounded-md tw-px-3 tw-text-[13px] tw-font-medium tw-flex tw-items-center tw-gap-2">
                           <i class="fas fa-filter tw-text-[12px] tw-text-gray-500"></i>
                           Filter
                       </button>
                   `);



        $(document).on('submit', 'form#add_leave_type_form, form#edit_leave_type_form', function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success == true) {
                        $('div#add_leave_type_modal').modal('hide');
                        $('.view_modal').modal('hide');
                        toastr.success(result.msg);
                        leave_type_table.ajax.reload();
                        $('form#add_leave_type_form')[0].reset();
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        })
    </script>
@endsection

<style>

    /* Table header */
    table.dataTable thead th {
        font-size: 11px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: .04em !important;
        color: #6b7280 !important;
        padding: 12px 14px !important;
        border-bottom: 1px solid #e5e7eb !important;
    }

    /* Table body */
    table.dataTable tbody td {
        font-size: 13px;
        padding: 12px 14px;
        color: #374151;
    }

    table.dataTable tbody tr {
        border-bottom: 1px solid #f1f5f9;
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


/* Also force on common components */
input,
textarea,
select,
button,
table,
th,
td,
span,
a,
p,
div,
h1, h2, h3, h4, h5, h6 {
    font-family: 'Roboto', sans-serif !important;
}


    </style>
