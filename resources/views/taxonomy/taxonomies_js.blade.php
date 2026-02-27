<script type="text/javascript">
    $(document).ready( function() {

        function getTaxonomiesIndexPage () {
            var data = {category_type : $('#category_type').val()};
            $.ajax({
                method: "GET",
                dataType: "html",
                url: '/taxonomies-ajax-index-page',
                data: data,
                async: false,
                success: function(result){
                    $('.taxonomy_body').html(result);
                }
            });
        }

        function initializeTaxonomyDataTable() {
            //Category table
            if ($('#category_table').length) {
                var category_type = $('#category_type').val();
                category_table = $('#category_table').DataTable({
                    processing: true,
                    serverSide: true,
                    fixedHeader:false,
                    pagingType: "numbers",

                    ajax: '/taxonomies?type=' + category_type,

                    buttons: [
                        { extend: 'csv', className: 'buttons-csv' },
                        { extend: 'excel', className: 'buttons-excel' },
                        { extend: 'pdf', className: 'buttons-pdf' }
                    ],

                    columns: [
                        { data: 'name', name: 'name', orderable: false, searchable: true },
                        @if($cat_code_enabled)
                            { data: 'short_code', name: 'short_code', orderable: false, searchable: true },
                        @endif
                        { data: 'description', name: 'description', orderable: false, searchable: true },
                        { data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                });

                let deptExportHtml = `
                <div class="tw-flex tw-items-center tw-gap-3 tw-mt-5 tw-text-[13px] tw-text-gray-600" style="padding-bottom:10px;">
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                            <i class="fas fa-file-csv tw-text-[11px]"></i>
                        </div>
                        <div class="tw-w-7 tw-h-7 tw-border tw-rounded tw-flex tw-items-center tw-justify-center tw-text-gray-500">
                            <i class="fas fa-file-excel tw-text-[11px]"></i>
                        </div>
                    </div>

                    <span>Export:</span>

                    <a href="#" class="tw-text-blue-600 hover:tw-underline dept-export-csv">CSV</a>
                    <a href="#" class="tw-text-blue-600 hover:tw-underline dept-export-xls">XLS</a>
                    <a href="#" class="tw-text-blue-600 hover:tw-underline dept-export-pdf">PDF</a>
                </div>
                `;

                $('#category_table').closest('.dataTables_wrapper').append(deptExportHtml);


                $(document).on('click', '.dept-export-csv', function(e) {
                    e.preventDefault();
                    $('#category_table').DataTable().button('.buttons-csv').trigger();
                });

                $(document).on('click', '.dept-export-xls', function(e) {
                    e.preventDefault();
                    $('#category_table').DataTable().button('.buttons-excel').trigger();
                });

                $(document).on('click', '.dept-export-pdf', function(e) {
                    e.preventDefault();
                    $('#category_table').DataTable().button('.buttons-pdf').trigger();
                });
            }
        }

        @if(empty(request()->get('type')))
            getTaxonomiesIndexPage();
        @endif

        initializeTaxonomyDataTable();
    });
    $(document).on('submit', 'form#category_add_form', function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            beforeSend: function(xhr) {
                __disable_submit_button(form.find('button[type="submit"]'));
            },
            success: function(result) {
                if (result.success === true) {
                    $('div.category_modal').modal('hide');
                    toastr.success(result.msg);
                    if(typeof category_table !== 'undefined') {
                        category_table.ajax.reload();
                    }

                    var evt = new CustomEvent("categoryAdded", {detail: result.data});
                    window.dispatchEvent(evt);

                    //event can be listened as
                    //window.addEventListener("categoryAdded", function(evt) {}
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
    $(document).on('click', 'button.edit_category_button', function() {
        $('div.category_modal').load($(this).data('href'), function() {
            $(this).modal('show');

            $('form#category_edit_form').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        if (result.success === true) {
                            $('div.category_modal').modal('hide');
                            toastr.success(result.msg);
                            category_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });

    $(document).on('click', 'button.delete_category_button', function() {
        swal({
            title: LANG.sure,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(willDelete => {
            if (willDelete) {
                var href = $(this).data('href');
                var data = $(this).serialize();

                $.ajax({
                    method: 'DELETE',
                    url: href,
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success === true) {
                            toastr.success(result.msg);
                            category_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });
</script>