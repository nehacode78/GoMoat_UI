@extends('layouts.app')

@section('title', __('report.reports'))

@section('content')
@include('crm::layouts.nav')
<!-- Content Header (Page header) -->

<!--

    <section class="content-header no-print">
       <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('report.reports')</h1>
    </section>


    -->


<section class="content no-print">
   <!--
    <div class="row">
           <div class="col-md-12">
           	@component('components.widget', ['class' => 'box-solid', 'title' => __('crm::lang.follow_ups_by_user')])
                   <div class="row">
                       <div class="col-md-4">
                           <div class="form-group">
                               {!! Form::label('follow_up_user_date_range', __('report.date_range') . ':') !!}
                               {!! Form::text('follow_up_user_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                           </div>
                       </div>
                   </div>
                   <table class="table table-bordered table-striped" id="follow_ups_by_user_table" style="width: 100%;">
                       <thead>
                           <tr>
                               <th>@lang('role.user')</th>
                               @foreach($statuses as $key => $value)
                                   <th>
                                       {{$value}}
                                   </th>
                               @endforeach
                               <th>
                                   @lang('lang_v1.others')
                               </th>
                               <th>
                                   @lang('crm::lang.total_follow_ups')
                               </th>
                           </tr>
                       </thead>
                   </table>
               @endcomponent
           </div>
       </div>
   -->


 <div class="row report-cards">

 <div class="col-md-3">
 <div class="report-card">

 <div class="report-card-header">
 <i class="fa fa-users"></i>
 <span>CUSTOMERS</span>
 </div>

 <div class="report-card-value">
 175
 <span class="growth up">▲ 25%</span>
 </div>

 <div class="report-card-sub">
 Last month: 2
 </div>

 </div>
 </div>


 <div class="col-md-3">
 <div class="report-card">

 <div class="report-card-header">
 <i class="fa fa-user"></i>
 <span>LEADS</span>
 </div>

 <div class="report-card-value">
 1
 <span class="growth down">▼ 25%</span>
 </div>

 <div class="report-card-sub">
 Last month: 2
 </div>

 </div>
 </div>


 <div class="col-md-3">
 <div class="report-card">

 <div class="report-card-header">
 <i class="fa fa-search"></i>
 <span>SOURCES</span>
 </div>

 <div class="report-card-value">
 1
 <span class="growth up">▲ 25%</span>
 </div>

 <div class="report-card-sub">
 Last month: 2
 </div>

 </div>
 </div>


 <div class="col-md-3">
 <div class="report-card">

 <div class="report-card-header">
 <i class="fa fa-clock"></i>
 <span>LIFE STAGES</span>
 </div>

 <div class="report-card-value">
 1
 <span class="growth down">▼ 25%</span>
 </div>

 <div class="report-card-sub">
 Last month: 2
 </div>

 </div>
 </div>

 </div>

   <!--
    <div class="row">
           <div class="col-md-12">
               @component('components.widget', ['class' => 'box-solid', 'title' => __('crm::lang.lead_to_customer_conversion')])
                   <table class="table table-bordered table-striped" id="lead_to_customer_conversion" style="width: 100%;">
                       <thead>
                           <tr>
                               <th>&nbsp;</th>
                               <th>@lang('crm::lang.converted_by')</th>
                               <th>@lang('sale.total')</th>
                           </tr>
                       </thead>
                   </table>
               @endcomponent
           </div>
       </div>
   -->


<div class="row">
    <div class="col-md-12">
        <div class="report-chart-card">

            <div class="chart-header">
                <span>Follow Ups by User</span>
                <span class="text-muted">This Month</span>
            </div>

         <canvas id="followupChart" height="70"></canvas>

        </div>
    </div>
</div>

 <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-solid', 'title' => __('crm::lang.follow_ups_by_contacts')])
                <table class="table table-bordered table-striped" id="follow_ups_by_contact_table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>@lang('contact.contact')</th>
                            @foreach($statuses as $key => $value)
                                <th>
                                    {{$value}}
                                </th>
                            @endforeach
                            <th>
                                @lang('lang_v1.others')
                            </th>
                            <th>
                                @lang('crm::lang.total_follow_ups')
                            </th>
                        </tr>
                    </thead>
                </table>
            @endcomponent
        </div>
    </div>


<div class="row">
    <div class="col-md-12">
        <div class="report-chart-card">

            <div class="chart-header">
                <span>Lead Targets</span>
                <span class="text-muted">This Month</span>
            </div>

            <canvas id="leadTargetChart" height="65"></canvas>

        </div>
    </div>
</div>


<div class="row">

    <!-- Follow Up Target -->
    <div class="col-md-4">
        <div class="report-chart-card">

            <div class="chart-header">
                <span>My Follow Up Target</span>
            </div>

            <canvas id="followupGauge"  ></canvas>

            <div style="text-align:center;font-size:12px;margin-top:10px;">
            Remaining: 152/200
            </div>

        </div>
    </div>


    <!-- Company Follow Ups -->
    <div class="col-md-4">
        <div class="report-table-card">

            <div class="chart-header">
                <span>Company Follow ups</span>
            </div>

            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>Target</td>
                    <td>Status</td>
                </tr>

                <tr>
                    <td>John</td>
                    <td>20</td>
                    <td><span class="label label-success">Done</span></td>
                </tr>

                <tr>
                    <td>Smith</td>
                    <td>10</td>
                    <td><span class="label label-danger">Pending</span></td>
                </tr>
            </table>

        </div>
    </div>


    <!-- Lead Conversion -->
    <div class="col-md-4">
        <div class="report-table-card">

            <div class="chart-header">
                <span>Leads to Customer Conversion</span>
            </div>

            <table class="table">
                <tr>
                    <td>User</td>
                    <td>Total</td>
                </tr>

                <tr>
                    <td>John</td>
                    <td>5</td>
                </tr>

                <tr>
                    <td>Smith</td>
                    <td>3</td>
                </tr>
            </table>

        </div>
    </div>

</div>


</section>
@endsection
@section('javascript')
    @include('crm::reports.report_javascripts')
@endsection


<style>
 .report-cards{
 margin-bottom:25px;
 }

 .report-card{
 background:#F8FAFC;
 border:1px solid #E5E7EB;
 border-radius:12px;
 padding:20px;
 height:135px;
 box-shadow:0 1px 2px rgba(0,0,0,0.04);
 }

 .report-card-header{
 display:flex;
 align-items:center;
 gap:8px;
 font-size:12px;
 font-weight:600;
 letter-spacing:.08em;
 color:#374151;
 margin-bottom:10px;
 }

 .report-card-header i{
 font-size:14px;
 color:#6B7280;
 }

 .report-card-value{
 font-size:34px;
 font-weight:700;
 color:#111827;
 display:flex;
 align-items:center;
 gap:8px;
 }

 .report-card-sub{
 font-size:11px;
 color:#9CA3AF;
 margin-top:2px;
 }

 .growth{
 font-size:12px;
 font-weight:600;
 }

 .growth.up{
 color:#16A34A;
 }

 .growth.down{
 color:#DC2626;
 }

   .report-chart-card{
       background:#F8FAFC;
       border:1px solid #E5E7EB;
       border-radius:10px;
       padding:25px;
       margin-bottom:25px;
   }

    .chart-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-weight:600;
        font-size:16px;
        color:#374151;
        margin-bottom:15px;
    }

   .report-table-card{
       background:#F8FAFC;
       border:1px solid #E5E7EB;
       border-radius:10px;
       padding:15px;
       margin-bottom:25px;
   }

   .table-header{
       display:flex;
       justify-content:space-between;
       align-items:center;
       margin-bottom:10px;
       font-weight:600;
   }

   .table-search{
       border:none;
       border-bottom:1px solid #D1D5DB;
       background:transparent;
       outline:none;
   }

   .report-table-card{
           background:#fff;
           border:1px solid #E5E7EB;
           border-radius:10px;
           padding:15px;
           height:230px;
       }


    </style>





<style>
    .content{
        max-width:1400px;
        margin:auto;
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

.col-md-4 .report-table-card,
.col-md-4 .report-chart-card{
    height:238px;
}

.table{
    font-size:12px;
}

.table td{
    border-top:1px solid #E5E7EB;
}

.report-card,
.report-chart-card,
.report-table-card{
    box-shadow:0 1px 2px rgba(0,0,0,0.03);
}

#followupGauge{
    filter: drop-shadow(0px 2px 3px rgba(0,0,0,0.05));
}

    </style>
