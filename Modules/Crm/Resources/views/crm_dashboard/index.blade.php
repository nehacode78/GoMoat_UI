@extends('layouts.app')

@section('title', __('crm::lang.crm'))

@section('css')
<style>
/* ─── CRM Dashboard ─── */
.crm-dashboard {
    background: #F4F6FA;
    min-height: 100vh;
    padding: 0 24px 40px 24px;
    font-family: 'Roboto', sans-serif;
    padding-top: 15px;
}

/* ── Scope Cards (top 3-col) ── */
.scope-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}
.scope-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    border: 1px solid #EAEDF2;
}
.scope-card.green-tint { background: linear-gradient(135deg,#F0FDF4 0%,#fff 60%); }
.scope-card.blue-tint  { background: linear-gradient(135deg,#EFF6FF 0%,#fff 60%); }
.scope-card .card-icon { width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:10px; }
.scope-card .card-icon.cyan  { background:#CFFAFE;color:#0891B2; }
.scope-card .card-icon.green { background:#DCFCE7;color:#16A34A; }
.scope-card .card-label { font-size:12px;font-weight:500;color:#6B7280;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px; }
.scope-card .card-value { font-size:36px;font-weight:700;color:#111827;line-height:1;margin-bottom:6px; }
.scope-card .card-sub   { font-size:12px;color:#9CA3AF; }
.trend { display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:600;padding:2px 6px;border-radius:20px;margin-left:6px; }
.trend.up   { color:#16A34A;background:#DCFCE7; }
.trend.down { color:#DC2626;background:#FEE2E2; }

/* ── Follow ups status card ── */
.followup-status { background:#fff;border-radius:14px;padding:20px 22px;border:1px solid #EAEDF2; }
.followup-status .fs-title { font-size:13px;font-weight:600;color:#374151;margin-bottom:14px;display:flex;align-items:center;gap:6px; }
.status-row { display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid #F3F4F6; }
.status-row:last-child { border-bottom:none; }
.status-dot { width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:7px; }
.dot-scheduled { background:#3B82F6; } .dot-open { background:#F59E0B; } .dot-cancelled { background:#EF4444; } .dot-completed { background:#10B981; }
.status-label { font-size:13px;color:#374151;display:flex;align-items:center; }
.status-count { font-size:13px;font-weight:600;color:#111827; }
.status-badge { font-size:10px;font-weight:700;padding:2px 6px;border-radius:10px;margin-left:6px; }
.badge-blue   { background:#DBEAFE;color:#1D4ED8; } .badge-yellow { background:#FEF3C7;color:#D97706; }
.badge-red    { background:#FEE2E2;color:#DC2626; } .badge-green  { background:#D1FAE5;color:#065F46; }

/* ── Section Header ── */
.section-header { font-size:13px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.08em;margin:24px 0 14px 0; }

/* ── Company cards ── */
.company-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px; }
.company-card { background:#fff;border-radius:12px;padding:18px 20px;border:1px solid #EAEDF2; }
.company-card .cc-label { font-size:12px;font-weight:500;color:#6B7280;text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px;display:flex;align-items:center;gap:6px; }
.company-card .cc-value { font-size:28px;font-weight:700;color:#111827;line-height:1.1;margin-bottom:4px; }
.company-card .cc-sub   { font-size:11px;color:#9CA3AF; }

/* ── 2-col data grid ── */
.data-grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px; }
.data-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden; }
.data-card .dc-header { padding:14px 18px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;justify-content:space-between; }
.data-card table { width:100%;border-collapse:collapse; }
.data-card table th { padding:9px 18px;font-size:11px;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:.05em;text-align:left;background:#FAFAFA;border-bottom:1px solid #F3F4F6; }
.data-card table td { padding:10px 18px;font-size:13px;color:#374151;border-bottom:1px solid #F9FAFB; }
.data-card table tr:last-child td { border-bottom:none; }

/* ── Full-width card ── */
.full-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden;margin-bottom:16px; }
.full-card .fc-header { padding:14px 20px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;justify-content:space-between; }
.full-card .fc-filters { padding:14px 20px;background:#FAFAFA;border-bottom:1px solid #F3F4F6;display:flex;gap:16px;align-items:flex-end; }
.full-card .fc-filters .form-group { margin-bottom:0; }
.full-card .fc-filters label { font-size:12px;font-weight:500;color:#6B7280;margin-bottom:4px;display:block; }
.full-card .fc-filters .form-control { height:34px;font-size:13px;border-radius:7px;border-color:#E5E7EB; }
.full-card table { width:100%;border-collapse:collapse; }
.full-card table th { padding:10px 16px;font-size:11px;font-weight:600;color:#9CA3AF;text-transform:uppercase;letter-spacing:.05em;text-align:left;background:#FAFAFA;border-bottom:1px solid #F3F4F6; }
.full-card table td { padding:11px 16px;font-size:13px;color:#374151;border-bottom:1px solid #F9FAFB; }

/* ── 3-col grid for gauge + follow ups by customer/user ── */
.three-col-grid { display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px; }

/* ── Gauge card ── */
.gauge-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden; }
.gauge-card .gc-header { padding:14px 18px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;gap:8px; }
.gauge-card .gc-body { padding:16px 18px;display:flex;flex-direction:column;align-items:center; }
.gauge-canvas-wrap { position:relative;width:200px;height:110px;overflow:hidden; }
.gauge-remaining { font-size:12px;color:#9CA3AF;margin-top:8px; }

/* ── Follow ups by customer / user list ── */
.followup-list-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden; }
.followup-list-card .flc-header { padding:14px 18px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;justify-content:space-between; }
.followup-list-card .flc-row { display:flex;align-items:center;justify-content:space-between;padding:10px 18px;border-bottom:1px solid #F9FAFB; }
.followup-list-card .flc-row:last-child { border-bottom:none; }
.flc-name { font-size:13px;color:#374151; }
.flc-count { font-size:13px;font-weight:600;color:#111827;margin-right:8px; }
.flc-badge { font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px; }
.flc-footer { padding:10px 18px;font-size:11px;color:#9CA3AF;border-top:1px solid #F3F4F6; }

/* ── Lead Targets 2-col ── */
.lead-targets-grid { display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px; }
.lead-targets-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden; }
.lead-targets-card .ltc-header { padding:14px 18px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;justify-content:space-between; }
.ltc-legend { display:flex;align-items:center;gap:6px;font-size:11px;color:#6B7280; }
.ltc-legend-dot { width:10px;height:10px;border-radius:2px;background:#22C55E; }
.ltc-chart-wrap { padding:16px 18px; }

/* Bar chart rows */
.bar-row { display:flex;align-items:center;margin-bottom:10px; }
.bar-label { width:120px;font-size:11px;color:#6B7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex-shrink:0; }
.bar-track { flex:1;height:18px;background:#F3F4F6;border-radius:4px;position:relative;overflow:visible; }
.bar-fill { height:100%;background:#67B578;border-radius:4px;position:relative;transition:width .4s; }
.bar-target-line { position:absolute;top:-3px;bottom:-3px;width:2px;background:#6B7280;border-radius:1px; }
.bar-target-label { position:absolute;top:-16px;font-size:9px;color:#6B7280;transform:translateX(-50%); white-space:nowrap; }

/* ── Follow ups overview ── */
.overview-card { background:#fff;border-radius:12px;border:1px solid #EAEDF2;overflow:hidden;margin-bottom:16px; }
.overview-card .oc-header { padding:14px 20px;border-bottom:1px solid #F3F4F6;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;justify-content:space-between; }
.oc-link { font-size:12px;color:#3B82F6;text-decoration:none; }
.oc-link:hover { text-decoration:underline; }

.fw-100 { font-weight:100; }

/* ── Refresh icon ── */
.refresh-btn { background:none;border:none;padding:0;cursor:pointer;color:#9CA3AF; }
.refresh-btn:hover { color:#374151; }
</style>
@endsection

@section('content')
@include('crm::layouts.nav')

<div class="crm-dashboard">

    <!-- ══ MY SCOPE ══ -->
    <p class="section-header">My Scope</p>
    <div class="scope-grid">

        @if (auth()->user()->can('crm.access_all_schedule') || auth()->user()->can('crm.access_own_schedule'))
        <div class="scope-card green-tint">
            <div class="card-icon cyan">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/><path d="M15 19l2 2l4 -4"/></svg>
            </div>
            <div class="card-label">{{ __('crm::lang.todays_followups') }}</div>
            <div class="card-value">{{ $todays_followups }}<span class="trend down">▼ 25%</span></div>
            <div class="card-sub">Last month: 2</div>
        </div>
        @endif

        @if (auth()->user()->can('crm.access_all_leads') || auth()->user()->can('crm.access_own_leads'))
        <div class="scope-card blue-tint">
            <div class="card-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4"/><path d="M15 19l2 2l4 -4"/></svg>
            </div>
            <div class="card-label">{{ __('crm::lang.my_leads') }}</div>
            <div class="card-value">{{ $my_leads }}<span class="trend up">▲ 25%</span></div>
            <div class="card-sub">Last month: 2</div>
        </div>
        @endif

        @if (auth()->user()->can('crm.access_all_schedule') || auth()->user()->can('crm.access_own_schedule'))
        <div class="followup-status">
            <div class="fs-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                My Follow ups
            </div>
            @foreach(['Scheduled'=>['dot-scheduled','badge-blue'],'Open'=>['dot-open','badge-yellow'],'Cancelled'=>['dot-cancelled','badge-red'],'Completed'=>['dot-completed','badge-green']] as $label=>[$dot,$badge])
            <div class="status-row">
                <span class="status-label"><span class="status-dot {{$dot}}"></span>{{$label}}</span>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="status-count"></span>
                    <span class="status-badge {{$badge}}">25%</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- ══ COMPANY UPDATES ══ -->
    @if ($is_admin)
    <p class="section-header">Company Updates</p>
    <div class="company-grid">
        <div class="company-card">
            <div class="cc-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24"><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/></svg>{{ __('lang_v1.customers') }}</div>
            <div class="cc-value">{{ $total_customers }}<span class="trend up" style="font-size:11px;">▲ 25%</span></div>
            <div class="cc-sub">Last month: 2</div>
        </div>
        <div class="company-card">
            <div class="cc-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4"/><path d="M15 19l2 2l4 -4"/></svg>{{ __('crm::lang.leads') }}</div>
            <div class="cc-value">{{ $total_leads }}<span class="trend down" style="font-size:11px;">▼ 25%</span></div>
            <div class="cc-sub">Last month: 2</div>
        </div>
        <div class="company-card">
            <div class="cc-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24"><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/><path d="M21 21l-6 -6"/></svg>{{ __('crm::lang.sources') }}</div>
            <div class="cc-value">{{ $total_sources }}<span class="trend down" style="font-size:11px;">▼ 25%</span></div>
            <div class="cc-sub">Last month: 2</div>
        </div>
        <div class="company-card">
            <div class="cc-label"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/></svg>{{ __('crm::lang.life_stages') }}</div>
            <div class="cc-value">{{ $total_life_stage }}<span class="trend down" style="font-size:11px;">▼ 25%</span></div>
            <div class="cc-sub">Last month: 2</div>
        </div>
    </div>

    <!-- ══ Leads to Customer Conversion + Leads per Life Stages ══ -->
    <div class="data-grid-2">
        <div class="data-card">
            <div class="dc-header"><span>Leads to Customer Conversion</span></div>
            <table>
                <thead><tr><th>Sources</th><th>Total</th><th>Conversion</th></tr></thead>
                <tbody>
                    @forelse($sources as $source)
                    <tr>
                        <td>{{ $source->name }}</td>
                        <td>{{ $leads_count_by_source[$source->id]['count'] ?? 0 }}</td>
                        <td>@if(!empty($customers_count_by_source[$source->id])&&!empty($contacts_count_by_source[$source->id]))@php $conv=($customers_count_by_source[$source->id]['count']/$contacts_count_by_source[$source->id]['count'])*100;@endphp{{ number_format($conv,0) }}%@else 0%@endif</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#9CA3AF;padding:20px;">@lang('lang_v1.no_data')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="data-card">
            <div class="dc-header"><span>Leads per Life Stages</span></div>
            <table>
                <thead><tr><th>Life Stage</th><th>Total</th></tr></thead>
                <tbody>
                    @forelse($life_stages as $ls)
                    <tr>
                        <td>{{ $ls->name }}</td>
                        <td>{{ !empty($leads_by_life_stage[$ls->id]) ? count($leads_by_life_stage[$ls->id]) : 0 }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align:center;color:#9CA3AF;padding:20px;">@lang('lang_v1.no_data')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══ Follow Up Target | Follow Ups by Customer | Follow ups by User ══ -->
    <div class="three-col-grid">

        <!-- Follow Up Target gauge -->
        <div class="gauge-card">
            <div class="gc-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Follow Up Target
            </div>
            <div class="gc-body">
                <canvas id="followUpGauge" width="220" height="120"></canvas>
                <div class="gauge-remaining" id="followUpRemaining">Remaining: 152/200</div>
            </div>
        </div>

        <!-- Follow Ups by Customer -->
        <div class="followup-list-card">
            <div class="flc-header">
                <span>Follow Ups by Customer</span>
                <button class="refresh-btn" onclick="refreshFollowUpsByCustomer()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg>
                </button>
            </div>
            <div id="followUpsByCustomerList">
                @for($i=0;$i<5;$i++)
                <div class="flc-row">
                    <span class="flc-name">Name Lastname</span>
                    <div style="display:flex;align-items:center;">
                        <span class="flc-count">0</span>
                        <span class="flc-badge" style="background:#DCFCE7;color:#16A34A;">25.4%</span>
                    </div>
                </div>
                @endfor
            </div>
            <div class="flc-footer">Compared with last month</div>
        </div>

        <!-- Follow ups by User -->
        <div class="followup-list-card">
            <div class="flc-header">
                <span>Follow ups by User</span>
                <button class="refresh-btn" onclick="refreshFollowUpsByUser()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg>
                </button>
            </div>
            <div id="followUpsByUserList">
                @for($i=0;$i<5;$i++)
                <div class="flc-row">
                    <span class="flc-name">Name Lastname</span>
                    <div style="display:flex;align-items:center;">
                        <span class="flc-count">0</span>
                        <span class="flc-badge" style="background:#DCFCE7;color:#16A34A;">25.4%</span>
                    </div>
                </div>
                @endfor
            </div>
            <div class="flc-footer">Compared with last month</div>
        </div>
    </div>

    <!-- ══ Lead Targets | Lead Target gauge ══ -->
    <div class="lead-targets-grid">

        <!-- Lead Targets bar chart -->
        <div class="lead-targets-card">
            <div class="ltc-header">
                <div style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l3 -3l3 3l3 -6l3 3l3 -3"/></svg>
                    <span>Lead Targets</span>
                    <span style="color:#9CA3AF;font-weight:400;">| This Month</span>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div class="ltc-legend"><span class="ltc-legend-dot"></span>achieved</div>
                    <button class="refresh-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg></button>
                </div>
            </div>
            <div class="ltc-chart-wrap" id="leadTargetsChart">
                <!-- Rendered by JS -->
                <div style="color:#9CA3AF;font-size:13px;text-align:center;padding:30px;">Loading...</div>
            </div>
        </div>

        <!-- Lead Target gauge (single) -->
        <div class="gauge-card">
            <div class="gc-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Lead Target
            </div>
            <div class="gc-body">
                <canvas id="leadTargetGauge" width="220" height="120"></canvas>
                <div class="gauge-remaining" id="leadTargetRemaining">Remaining: 152/200</div>
            </div>
        </div>
    </div>

    <!-- ══ Follow ups overview (full width) ══ -->
    <div class="overview-card">
        <div class="oc-header">
            <div style="display:flex;align-items:center;gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Follow ups overview
            </div>
            <a href="{{ action([\Modules\Crm\Http\Controllers\ReportController::class, 'index']) }}" class="oc-link">View All Follow ups Reports</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="table table-bordered table-striped" id="follow_ups_overview_table" style="width:100%;margin:0;">
                <thead>
                    <tr>
                        <th>@lang('role.user')</th>
                        <th>Contact</th>
                        <th>Scheduled</th>
                        <th>Open</th>
                        <th>Cancelled</th>
                        <th>Completed</th>
                        <th>Others</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @endif

</div>
@endsection

@section('javascript')
<script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
@include('crm::reports.report_javascripts')
<script type="text/javascript">

/* ── Gauge drawing utility ── */
function drawGauge(canvasId, value, max, label) {
    var canvas = document.getElementById(canvasId);
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var cx = canvas.width / 2, cy = canvas.height - 10;
    var r = 85;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Background arc segments: red -> yellow -> green
    var segments = [
        { color: '#FCA5A5', start: Math.PI, end: Math.PI * 1.25 },
        { color: '#FCD34D', start: Math.PI * 1.25, end: Math.PI * 1.6 },
        { color: '#6EE7B7', start: Math.PI * 1.6, end: Math.PI * 2 }
    ];
    segments.forEach(function(s) {
        ctx.beginPath();
        ctx.arc(cx, cy, r, s.start, s.end);
        ctx.lineWidth = 20;
        ctx.strokeStyle = s.color;
        ctx.stroke();
    });

    // Value arc
    var pct = Math.min(value / max, 1);
    var endAngle = Math.PI + (pct * Math.PI);
    ctx.beginPath();
    ctx.arc(cx, cy, r, Math.PI, endAngle);
    ctx.lineWidth = 20;
    ctx.strokeStyle = '#22C55E';
    ctx.stroke();

    // Min/max labels
    ctx.fillStyle = '#6B7280';
    ctx.font = '11px DM Sans, sans-serif';
    ctx.fillText('0', cx - r - 10, cy + 4);
    ctx.fillText(max, cx + r - 14, cy + 4);

    // Value label
    ctx.fillStyle = '#374151';
    ctx.font = 'bold 16px DM Sans, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(value, cx, cy - r / 2);
    ctx.font = '11px DM Sans, sans-serif';
    ctx.fillStyle = '#9CA3AF';
    ctx.fillText(label || '', cx, cy - r / 2 + 18);
    ctx.textAlign = 'left';

    // Needle
    var needleAngle = Math.PI + (pct * Math.PI);
    var needleLen = r - 10;
    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.lineTo(
        cx + needleLen * Math.cos(needleAngle),
        cy + needleLen * Math.sin(needleAngle)
    );
    ctx.lineWidth = 2;
    ctx.strokeStyle = '#374151';
    ctx.stroke();

    // Center dot
    ctx.beginPath();
    ctx.arc(cx, cy, 5, 0, Math.PI * 2);
    ctx.fillStyle = '#374151';
    ctx.fill();
}

/* ── Bar chart for Lead Targets ── */
function renderLeadTargets(data) {
    var container = document.getElementById('leadTargetsChart');
    if (!container) return;
    if (!data || data.length === 0) {
        container.innerHTML = '<div style="color:#9CA3AF;font-size:13px;text-align:center;padding:30px;">No data</div>';
        return;
    }

    var maxVal = Math.max.apply(null, data.map(function(d) { return Math.max(d.achieved, d.target); }));
    var html = '';
    data.forEach(function(row) {
        var pct = maxVal > 0 ? (row.achieved / maxVal * 100) : 0;
        var targetPct = maxVal > 0 ? (row.target / maxVal * 100) : 0;
        html += '<div class="bar-row">'
            + '<div class="bar-label" title="' + row.name + '">' + row.name + '</div>'
            + '<div class="bar-track">'
            +   '<div class="bar-fill" style="width:' + pct + '%"></div>'
            +   '<div class="bar-target-line" style="left:' + targetPct + '%">'
            +     '<div class="bar-target-label">target: ' + row.target + '</div>'
            +   '</div>'
            + '</div>'
            + '</div>';
    });
    container.innerHTML = html;
}

/* ── Init ── */
$(document).ready(function() {

    // Draw gauges with placeholder values (replace with real data from controller)
    drawGauge('followUpGauge', 48, 200, '');
    drawGauge('leadTargetGauge', 48, 200, '');

    // Sample lead targets data - replace with real AJAX if available
    var sampleTargets = [
        { name: 'MR. BHAVESH MEHETA', achieved: 180, target: 190 },
        { name: 'MISS SONALI DESAI',  achieved: 110, target: 110 },
        { name: 'MR. PADAM TAMATTA',  achieved: 90,  target: 130 },
        { name: 'MR. PINKESH GHAGNADA', achieved: 140, target: 160 },
        { name: 'MR. SAGAR',           achieved: 100, target: 150 },
    ];
    renderLeadTargets(sampleTargets);

    // Follow ups overview DataTable
    if ($.fn.DataTable) {
        $('#follow_ups_overview_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ action([\Modules\Crm\Http\Controllers\ReportController::class, 'followUpsByUser']) }}",
                data: function(d) {
                    d.followup_category_id = $('#followup_category_id').val();
                }
            },
            columns: [
                { data: 'user',      name: 'user',      orderable: false },
                { data: 'contact',   name: 'contact',   orderable: false },
                { data: 'scheduled', name: 'scheduled', orderable: false },
                { data: 'open',      name: 'open',      orderable: false },
                { data: 'cancelled', name: 'cancelled', orderable: false },
                { data: 'completed', name: 'completed', orderable: false },
                { data: 'others',    name: 'others',    orderable: false },
                { data: 'total',     name: 'total',     orderable: false },
                { data: 'action',    name: 'action',    orderable: false, searchable: false },
            ],
        });
    }

    @if(config('constants.enable_crm_call_log'))
    all_users_call_log = $("#all_users_call_log").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        'ajax': {
            url: "{{ action([\Modules\Crm\Http\Controllers\CallLogController::class, 'allUsersCallLog']) }}"
        },
        columns: [
            { data: 'username',     name: 'u.username' },
            { data: 'calls_today',  searchable: false },
            { data: 'calls_yesterday', searchable: false },
            { data: 'all_calls',    searchable: false }
        ],
    });
    @endif

    $(document).on('click', '#wish_birthday', function() {
        var url = $(this).data('href');
        var contact_ids = [];
        $("input.contat_id").each(function() {
            if ($(this).is(":checked")) contact_ids.push($(this).val());
        });
        if (_.isEmpty(contact_ids)) {
            alert("{{ __('crm::lang.plz_select_user') }}");
        } else {
            location.href = url + '?contact_ids=' + contact_ids;
        }
    });
});

function refreshFollowUpsByCustomer() { /* Hook to your data source */ }
function refreshFollowUpsByUser()     { /* Hook to your data source */ }
</script>
@endsection