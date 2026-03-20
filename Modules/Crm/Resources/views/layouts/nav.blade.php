
    @if(request()->segment(1) == 'crm')

    @php
        $segment = request()->segment(2);
        $currentPage = $segment
            ? ucwords(str_replace('-', ' ', $segment))
            : 'Dashboard';
    @endphp

    <div class="tw-flex tw-items-center tw-justify-between tw-mx-[16px] tw-mt-6"
         style="margin-left:40px; margin-bottom:24px; padding-top:9px; margin-right:18px;">

        <div class="tw-text-xl tw-font-semibold">
            <span class="tw-text-gray-400">CRM</span>
            <span class="tw-mx-2 tw-text-gray-300">|</span>
            <span class="tw-text-gray-900">{{ $currentPage }}</span>
        </div>


        <div class="tw-flex tw-items-center tw-gap-6">

            {{-- Date (hide on dashboard if you want same behavior as HRM) --}}
            @if(request()->segment(2) !== null)
                <div class="tw-text-sm tw-text-gray-400">
                    {{ \Carbon\Carbon::now()->format('d M, Y') }}
                </div>
            @endif

            {{-- Example: Show button only on settings page --}}
            @if(request()->segment(2) == 'settings')
                <button type="submit"
                    form="crm_settings_form"
                    class="hover:tw-bg-[#1f5bd8]
                           tw-text-white tw-rounded-md
                           tw-px-5 tw-py-2 tw-text-sm tw-font-medium"
                    style="background-color:#2B7ADA;">
                    Update Settings
                </button>
            @endif

        </div>

    </div>

    @endif

<!--
    <section class="no-print">
        <style type="text/css">
            #contacts_login_dropdown::after {
                display: inline-block;
                width: 0;
                height: 0;
                margin-left: 0.255em;
                vertical-align: 0.255em;
                content: "";
                border-top: 0.3em solid;
                border-right: 0.3em solid transparent;
                border-bottom: 0;
                border-left: 0.3em solid transparent;
            }
        </style>
        <nav class="navbar-default tw-transition-all tw-duration-5000 tw-shrink-0 tw-rounded-2xl tw-m-2 tw-border-2 !tw-bg-white">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="margin-top: 3px; margin-right: 3px;">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{action([\Modules\Crm\Http\Controllers\CrmDashboardController::class, 'index'])}}"><i class="fas fa fa-broadcast-tower"></i> {{__('crm::lang.crm')}}</a>
                </div>


                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(auth()->user()->can('crm.access_all_leads') || auth()->user()->can('crm.access_own_leads'))
                        <li @if(request()->segment(2) == 'leads') class="active" @endif><a href="{{action([\Modules\Crm\Http\Controllers\LeadController::class, 'index']). '?lead_view=list_view'}}">@lang('crm::lang.leads')</a></li>
                        @endif
                        @if(auth()->user()->can('crm.access_all_schedule') || auth()->user()->can('crm.access_own_schedule'))
                        <li @if(request()->segment(2) == 'follow-ups') class="active" @endif><a href="{{action([\Modules\Crm\Http\Controllers\ScheduleController::class, 'index'])}}">@lang('crm::lang.follow_ups')</a></li>
                        @endif
                        @if(auth()->user()->can('crm.access_all_campaigns') || auth()->user()->can('crm.access_own_campaigns'))
                        <li @if(request()->segment(2) == 'campaigns') class="active" @endif><a href="{{action([\Modules\Crm\Http\Controllers\CampaignController::class, 'index'])}}">@lang('crm::lang.campaigns')</a></li>
                        @endif

                        @can('crm.access_contact_login')
                            <li class="nav-item @if(request()->segment(2) == 'all-contacts-login' || request()->segment(2) == 'commissions') active @endif">
                                <a class="nav-link dropdown-toggle" href="#" id="contacts_login_dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('crm::lang.contacts_login')
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{action([\Modules\Crm\Http\Controllers\ContactLoginController::class, 'allContactsLoginList'])}}"> @lang('crm::lang.contacts_login')</a>
                                  <a class="dropdown-item" href="{{action([\Modules\Crm\Http\Controllers\ContactLoginController::class, 'commissions'])}}">@lang('crm::lang.commissions')</a>
                                </div>
                            </li>
                        @endcan
                        @if((auth()->user()->can('crm.view_all_call_log') || auth()->user()->can('crm.view_own_call_log')) && config('constants.enable_crm_call_log'))
                        <li @if(request()->segment(2) == 'call-log') class="active" @endif><a href="{{action([\Modules\Crm\Http\Controllers\CallLogController::class, 'index'])}}">@lang('crm::lang.call_log')</a></li>
                        @endif

                        @can('crm.view_reports')
                        <li @if(request()->segment(2) == 'reports') class="active" @endif><a href="{{action([\Modules\Crm\Http\Controllers\ReportController::class, 'index'])}}">@lang('report.reports')</a></li>
                        @endcan
                        <li @if(request()->segment(2) == 'proposal-template') class="active" @endif>
                            <a href="{{action([\Modules\Crm\Http\Controllers\ProposalTemplateController::class, 'index'])}}">
                                @lang('crm::lang.proposal_template')
                            </a>
                        </li>
                        <li @if(request()->segment(2) == 'proposals') class="active" @endif>
                            <a href="{{action([\Modules\Crm\Http\Controllers\ProposalController::class, 'index'])}}">
                                @lang('crm::lang.proposals')
                            </a>
                        </li>
                        @if(auth()->user()->can('crm.access_b2b_marketplace') && config('constants.enable_b2b_marketplace'))
                        <li @if(request()->segment(2) == 'b2b-marketplace') class="active" @endif>
                            <a href="{{action([\Modules\Crm\Http\Controllers\CrmMarketplaceController::class, 'index'])}}">
                                @lang('crm::lang.b2b_marketplace')
                            </a>
                        </li>
                        @endif

                        @can('crm.access_sources')
                            <li @if(request()->get('type') == 'source') class="active" @endif><a href="{{action([\App\Http\Controllers\TaxonomyController::class, 'index']) . '?type=source'}}">@lang('crm::lang.sources')</a></li>
                        @endcan

                        @can('crm.access_life_stage')
                            <li @if(request()->get('type') == 'life_stage') class="active" @endif><a href="{{action([\App\Http\Controllers\TaxonomyController::class, 'index']) . '?type=life_stage'}}">@lang('crm::lang.life_stage')</a></li>

                            <li @if(request()->get('type') == 'followup_category') class="active" @endif><a href="{{action([\App\Http\Controllers\TaxonomyController::class, 'index']) . '?type=followup_category'}}">@lang('crm::lang.followup_category')</a></li>
                        @endcan
                        <li @if(request()->segment(2) == 'settings') class="active" @endif>
                            <a href="{{action([\Modules\Crm\Http\Controllers\CrmSettingsController::class, 'index'])}}">
                                @lang('business.settings')
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </section>
    -->


