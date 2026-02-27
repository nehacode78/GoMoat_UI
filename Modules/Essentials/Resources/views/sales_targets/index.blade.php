@extends('layouts.app')
@section('title', __('essentials::lang.sales_target'))

@section('content')
@include('essentials::layouts.nav_hrm')

<!--
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black" >@lang('essentials::lang.sales_target')
        </h1>
    </section>

    -->

<!-- Main content -->
<section class="content">



    <div class="row">

        <div class="col-md-12">

            @component('components.widget', ['class' => 'box-solid'])

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="sales_target_table">
                        <thead>
                            <tr>
                                <th>@lang( 'report.user' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade" id="set_sales_target_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
          sales_target_table = $('#sales_target_table').DataTable({
              processing: true,
              serverSide: true,
              fixedHeader:false,
              dom:
                  "<'tw-flex tw-items-center tw-justify-between tw-mb-3 tw-mt-4 sales-target-header'>" +
                  "<'row position'<'col-sm-6'l><'col-sm-6'f>>" +
                  "rt" +
                  "<'row'<'col-sm-5'i><'col-sm-7'>>",

              buttons: [
                  { extend: 'csv', className: 'buttons-csv' },
                  { extend: 'excel', className: 'buttons-excel' },
                  { extend: 'pdf', className: 'buttons-pdf' }
              ],

              ajax: {
                  url: "{{action([\Modules\Essentials\Http\Controllers\SalesTargetController::class, 'index'])}}"
              },
              columns: [
                  { data: 'full_name', name: 'full_name' },
                  { data: 'action', name: 'action' },
              ],
          });

          let salesExportHtml = `
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

              <a href="#" class="tw-text-blue-600 hover:tw-underline sales-export-csv">CSV</a>
              <a href="#" class="tw-text-blue-600 hover:tw-underline sales-export-xls">XLS</a>
              <a href="#" class="tw-text-blue-600 hover:tw-underline sales-export-pdf">PDF</a>
          </div>
          `;

          $('#sales_target_table').closest('.dataTables_wrapper').append(salesExportHtml);


          $(document).on('click', '.sales-export-csv', function(e) {
              e.preventDefault();
              sales_target_table.button('.buttons-csv').trigger();
          });

          $(document).on('click', '.sales-export-xls', function(e) {
              e.preventDefault();
              sales_target_table.button('.buttons-excel').trigger();
          });

          $(document).on('click', '.sales-export-pdf', function(e) {
              e.preventDefault();
              sales_target_table.button('.buttons-pdf').trigger();
          });

            $('.sales-target-header').html(`
                <div class="tw-flex tw-items-center tw-gap-2 size">
                    <i class="fas fa-bullseye tw-text-gray-500"></i>
                    <span class="tw-font-semibold tw-text-gray-800">Sales Targets</span>
                </div>
            `);

            $(document).on('submit', 'form#add_holiday_form', function(e) {
                e.preventDefault();
                $(this).find('button[type="submit"]').attr('disabled', true);
                var data = $(this).serialize();

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('div#add_holiday_modal').modal('hide');
                            toastr.success(result.msg);
                            holidays_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });

        $(document).on('click', '#add_target', function(e) {
            $('#target_table tbody').append($('#sales_target_row_hidden tbody').html());
        });
        $(document).on('click', '.remove_target', function(e) {
            $(this).closest('tr').remove();
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
.size{
font-size:16px;
}
.position{
margin-top:44px !important;
}


/* ===== Set Sales Target Button Styling ===== */
#sales_target_table tbody td:last-child .btn,
#sales_target_table tbody td:last-child button,
#sales_target_table tbody td:last-child a {

    background-color: #EAF2FB !important;
    color: #213650 !important;
    border: 1px solid #dbeafe !important;
    border-radius: 6px !important;
    padding: 6px 14px !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    box-shadow: none !important;
}

/* Hover effect */
#sales_target_table tbody td:last-child .btn:hover,
#sales_target_table tbody td:last-child button:hover,
#sales_target_table tbody td:last-child a:hover {

    background-color: #dbeafe !important;
}


    </style>
