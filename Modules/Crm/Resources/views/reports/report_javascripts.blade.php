<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script type="text/javascript">
    $(document).ready(function(){

    var opts = {
      angle: 0.15,
      lineWidth: 0.25,
      radiusScale: 1,
      highDpiSupport: true,

      pointer: {
        length: 0.6,
        strokeWidth: 0.02,
        color: '#8B97A8'
      },

      generateGradient: true,

      staticZones: [
        { strokeStyle: "rgba(248,113,113,0.8)", min: 0, max: 60 },
        { strokeStyle: "rgba(253,224,71,0.8)", min: 60, max: 140 },
        { strokeStyle: "rgba(134,239,172,0.8)", min: 140, max: 200 }
      ],

      staticLabels: {
        font: "11px sans-serif",
        labels: [0,48,200],
        color: "#6B7280",
        fractionDigits: 0
      }
    };

    var target = document.getElementById('followupGauge');
    var gauge = new Gauge(target).setOptions(opts);

    gauge.maxValue = 200;
    gauge.setMinValue(0);
    gauge.animationSpeed = 32;
    gauge.set(48);

        if($('#follow_ups_by_user_table').length > 0){

            $('#follow_up_user_date_range').daterangepicker(
                dateRangeSettings,
                function (start, end) {
                    $('#follow_up_user_date_range').val(start.format(moment_date_format) + ' - ' + end.format(moment_date_format));
                    //pass parameter in ajax call
                    follow_ups_by_user_table.ajax.reload();
                }
            );
            $('#follow_up_user_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#follow_up_user_date_range').val('');
                //pass parameter in ajax call
                follow_ups_by_user_table.ajax.reload();
            });

            $('#followup_category_id').change(function(){
                follow_ups_by_user_table.ajax.reload();
            });
        
            var follow_ups_by_user_table = 
            $("#follow_ups_by_user_table").DataTable({
                processing: true,
                serverSide: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                fixedHeader: false,
                'ajax': {
                    url: "{{action([\Modules\Crm\Http\Controllers\ReportController::class, 'followUpsByUser'])}}",

                    data: function(d) {
                        var start = '';
                        var end = '';
                        if ($('#follow_up_user_date_range').val()) {
                            start = $('input#follow_up_user_date_range')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            end = $('input#follow_up_user_date_range')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }

                        d.start_date = start;
                        d.end_date = end;
                        d.followup_category_id = $('#followup_category_id').val();
                    },

                },
                columns: [
                    { data: 'full_name', name: 'full_name' },
                    @foreach($statuses as $key => $value)
                        { data: 'count_{{$key}}', searchable: false },
                    @endforeach
                    { data: 'count_nulled', searchable: false },
                    { data: 'total_follow_ups', searchable: false }
                ],
            });
        }

        var follow_ups_by_contact_table =
        $("#follow_ups_by_contact_table").DataTable({
            processing: true,
            serverSide: true,
            scrollY: "75vh",
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: false,
            'ajax': {
                url: "{{action([\Modules\Crm\Http\Controllers\ReportController::class, 'followUpsContact'])}}"
            },
            columns: [
                { data: 'contact_name', name: 'contact_name' },
                @foreach($statuses as $key => $value)
                    { data: 'count_{{$key}}', searchable: false },
                @endforeach
                { data: 'count_nulled', searchable: false },
                { data: 'total_follow_ups', searchable: false }
            ],
        });

        var lead_to_customer_conversion = 
        $("#lead_to_customer_conversion").DataTable({
            processing: true,
            serverSide: true,
            scrollY: "75vh",
            scrollX: true,
            scrollCollapse: true,
            fixedHeader: false,
            aaSorting: [[1, 'desc']],
            'ajax': {
                url: "{{action([\Modules\Crm\Http\Controllers\ReportController::class, 'leadToCustomerConversion'])}}"
            },
            columns: [
                {
                    orderable: false,
                    searchable: false,
                    data: null,
                    defaultContent: '',
                },
                { data: 'full_name', name: 'full_name' },
                { data: 'total_conversions', searchable: false }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(0)')
                    .addClass('details-control');
            },
        });

        // Array to track the ids of the details displayed rows
        var ltc_detail_rows = [];

        $('#lead_to_customer_conversion tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = lead_to_customer_conversion.row(tr);
            var idx = $.inArray(tr.attr('id'), ltc_detail_rows);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                // Remove from the 'open' array
                ltc_detail_rows.splice(idx, 1);
            } else {
                tr.addClass('details');

                row.child(show_lead_to_customer_details(row.data())).show();

                // Add to the 'open' array
                if (idx === -1) {
                    ltc_detail_rows.push(tr.attr('id'));
                }
            }
        });



        // Lead Targets Chart
        new Chart(document.getElementById('leadTargetChart'), {

            type:'bar',

            data:{
                labels:[
                    'Email Campaign',
                    'Cold Call',
                    'Website',
                    'Referral',
                    'Event'
                ],

                datasets:[
                    {
                        data:[80,60,40,50,70],
                        backgroundColor:'#22C55E'
                    }
                ]
            },

           options:{
               indexAxis:'y',
               responsive:true,
               scales:{
                   x:{
                       grid:{color:'#E5E7EB'}
                   },
                   y:{
                       grid:{display:false}
                   }
               },
               plugins:{
                   legend:{display:false}
               }
           }

        });


        new Chart(document.getElementById('followupChart'),{

            type:'bar',

            data:{
                labels:[
                    'Mr. Bhavesh Mehta',
                    'Mrs. Sonali Desai',
                    'Mr. Pradip Tambe',
                    'Mr. Pritesh Ghaghada',
                    'Mr. Sagar',
                    'Mr. Rahul Verma',
                    'Mr. Harsh Shah'
                ],

                datasets:[

                    {
                        label:'scheduled',
                        data:[2,1,1,1,3,2,0],
                        backgroundColor:'#FBBF24',
                        borderRadius:4
                    },

                    {
                        label:'open',
                        data:[18,5,22,15,10,8,6],
                        backgroundColor:'#60A5FA',
                        borderRadius:4
                    },

                    {
                        label:'cancelled',
                        data:[3,0,0,2,5,1,0],
                        backgroundColor:'#F87171',
                        borderRadius:4
                    },

                    {
                        label:'completed',
                        data:[15,12,20,10,7,15,25],
                        backgroundColor:'#4ADE80',
                        borderRadius:4
                    }

                ]
            },

            options:{
                responsive:true,

                indexAxis:'y',   // ⭐ makes chart horizontal

                plugins:{
                    legend:{
                        position:'top',
                        align:'end',
                        labels:{
                            boxWidth:10,
                            font:{size:11}
                        }
                    }
                },

                scales:{
                    x:{
                        stacked:true,
                        grid:{
                            color:'#E5E7EB'
                        }
                    },

                    y:{
                        stacked:true,
                        grid:{
                            display:false
                        }
                    }
                }
            }

        });


        new Chart(document.getElementById('followupTargetChart'), {

            type:'doughnut',

            data:{
                labels:['Completed','Remaining'],
               datasets:[{
                   data:[70,30],
                   backgroundColor:[
                       '#4ADE80',
                       '#F3F4F6'
                   ],
                   borderWidth:0
               }]
            },

            options:{
                rotation:-90,
                circumference:180,
                cutout:'70%',
                plugins:{
                    legend:{display:false}
                }
            }

        });

        // On each draw, loop over the `detailRows` array and show any child rows
        lead_to_customer_conversion.on('draw', function() {
            $.each(ltc_detail_rows, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });

        function show_lead_to_customer_details(rowData) {
            var div = $('<div/>')
                .addClass('loading')
                .text('Loading...');
            $.ajax({
                url: '/crm/lead-to-customer-details/' + rowData.DT_RowId,
                dataType: 'html',
                success: function(data) {
                    div.html(data).removeClass('loading');
                },
            });

            return div;
        }
    });


</script>
