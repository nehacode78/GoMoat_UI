@inject('request', 'Illuminate\Http\Request')
<!-- Main Header -->

<div class=" tw-transition-all tw-duration-5000 tw-border-b header-white-bg tw-shrink-0 lg:tw-h-15 tw-border-primary-500/30 no-print">
    <div class="tw-px-4 tw-py-3 tw-mt-2">

        <div class="tw-flex tw-items-start tw-justify-between tw-gap-4 lg:tw-items-center">
                    <!--
                    <div class="tw-flex tw-items-center tw-gap-3">
                                            <button type="button"
                                                class="small-view-button xl:tw-w-20 lg:tw-hidden tw-inline-flex tw-items-center tw-justify-center
                                                tw-text-sm tw-font-medium header-btn tw-transition-all tw-duration-200
                                                 tw-p-1.5 tw-rounded-lg tw-ring-1 hover:tw-text-white">
                                                <span class="tw-sr-only">
                                                    Sidebar Menu
                                                </span>
                                                <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 6l16 0" />
                                                    <path d="M4 12l16 0" />
                                                    <path d="M4 18l16 0" />
                                                </svg>
                                            </button>

                                        </div>
                    -->

                 {{-- WELCOME TEXT --}}
                  <div class="tw-flex tw-items-center tw-gap-3 tw-flex-1">

                      <!-- Sidebar Toggle (mobile only) -->
                      <button id="mobileSidebarToggle"
                          class="lg:tw-hidden tw-flex tw-items-center tw-justify-center
                                 tw-w-9 tw-h-9 tw-rounded-full
                                 tw-bg-gray-100 hover:tw-bg-gray-200 tw-text-gray-700">

                          <svg xmlns="http://www.w3.org/2000/svg"
                               class="tw-w-5 tw-h-5"
                               viewBox="0 0 24 24"
                               fill="none"
                               stroke="currentColor"
                               stroke-width="2">
                              <path d="M15 18l-6-6 6-6"/>
                          </svg>

                      </button>

                      {{-- WELCOME TEXT --}}
                      <div class="tw-flex-1 tw-ml-1 lg:tw-ml-6">
                          <h1 class="tw-text-lg md:tw-text-2xl welcome-text
                                     tw-tracking-tight tw-text-primary-800
                                     tw-font-semibold tw-truncate">
                              {{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
                          </h1>
                      </div>

                  </div>

                    {{-- Showing active package for SaaS Superadmin --}}
                    @if(Module::has('Superadmin'))
                        @includeIf('superadmin::layouts.partials.active_subscription')
                    @endif

                    {{-- When using superadmin, this button is used to switch users --}}
                    @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
                        <a href="{{route('sign-in-as-user', session('previous_user_id'))}}" class="btn btn-flat btn-danger m-8 btn-sm mt-10"><i class="fas fa-undo"></i> @lang('lang_v1.back_to_username', ['username' => session('previous_username')] )</a>
                    @endif


                    <div class="tw-flex tw-items-center tw-gap-4 header-clean-tabs">


                       <!--

                       <details class="tw-dw-dropdown tw-relative tw-inline-block tw-text-left">
                                                   <summary
                                                       class="tw-inline-flex tw-transition-all  header-btn
                                                       hover:tw-text-white tw-cursor-pointer tw-duration-200 header-btn
                                                        tw-py-1.5 tw-px-3 tw-rounded-lg tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-gap-1">
                                                       <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                           stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                                           stroke-linejoin="round">
                                                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                           <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                           <path d="M9 12h6" />
                                                           <path d="M12 9v6" />
                                                       </svg>
                                                   </summary>
                                                   <ul class="tw-dw-menu tw-dw-dropdown-content tw-dw-z-[1] tw-dw-bg-base-100 tw-dw-rounded-box tw-w-48 tw-absolute tw-left-0 tw-z-10 tw-mt-2 tw-origin-top-right tw-bg-white tw-rounded-lg tw-shadow-lg tw-ring-1 tw-ring-gray-200 focus:tw-outline-none"
                                                       role="menu" tabindex="-1">
                                                       <div class="tw-p-2" role="none">
                                                           <a href="{{ route('calendar') }}"
                                                               class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-gray-900 hover:tw-bg-gray-100"
                                                               role="menuitem" tabindex="-1">
                                                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar"
                                                                   width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                   stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                   <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                   <rect x="4" y="5" width="16" height="16" rx="2" />
                                                                   <line x1="16" y1="3" x2="16" y2="7" />
                                                                   <line x1="8" y1="3" x2="8" y2="7" />
                                                                   <line x1="4" y1="11" x2="20" y2="11" />
                                                                   <line x1="11" y1="15" x2="12" y2="15" />
                                                                   <line x1="12" y1="15" x2="12" y2="18" />
                                                               </svg>
                                                               @lang('lang_v1.calendar')
                                                           </a>
                                                           @if (Module::has('Essentials'))
                                                               <a href="#"
                                                                   data-href="{{ action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'create']) }}"
                                                                   data-container="#task_modal"
                                                                   class="btn-modal tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-gray-900 hover:tw-bg-gray-100"
                                                                   role="menuitem" tabindex="-1">
                                                                   <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                                                       viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                                                       stroke-linecap="round" stroke-linejoin="round">
                                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                       <path
                                                                           d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                                       <path d="M9 12l2 2l4 -4" />
                                                                   </svg>
                                                                   @lang('essentials::lang.add_to_do')
                                                               </a>
                                                           @endif
                                                           @if (auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
                                                               <a href="#" id="start_tour"
                                                                   class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-gray-900 hover:tw-bg-gray-100"
                                                                   role="menuitem" tabindex="-1">
                                                                   <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                                                       viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                                                       stroke-linecap="round" stroke-linejoin="round">
                                                                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                       <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                       <path d="M12 17l0 .01" />
                                                                       <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                                                                   </svg>
                                                                   @lang('lang_v1.application_tour')
                                                               </a>
                                                           @endif
                                                       </div>
                                                   </ul>
                                               </details>
                       -->


                        {{-- data-toggle="popover" remove this for on hover show --}}

                        <!--

                        <button id="btnCalculator" title="@lang('lang_v1.calculator')" data-content='@include('layouts.partials.calculator')'
                                                    type="button" data-trigger="click" data-html="true" data-placement="bottom"
                                                    class="tw-hidden md:tw-inline-flex tw-items-center tw-justify-center tw-text-sm tw-font-medium  tw-transition-all tw-duration-200  tw-p-1.5 tw-rounded-lg  hover:tw-text-white">
                                                    <span class="tw-sr-only" aria-hidden="true">
                                                        Calculator
                                                    </span>
                                                    <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 3m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                                        <path d="M8 7m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                                                        <path d="M8 14l0 .01" />
                                                        <path d="M12 14l0 .01" />
                                                        <path d="M16 14l0 .01" />
                                                        <path d="M8 17l0 .01" />
                                                        <path d="M12 17l0 .01" />
                                                        <path d="M16 17l0 .01" />
                                                    </svg>
                                                </button>
                        -->


                       <!--

                       @if (in_array('pos_sale', $enabled_modules))
                                                   @can('sell.create')
                                                       <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}"
                                                           class="sm:tw-inline-flex tw-transition-all tw-duration-200 tw-gap-2 tw-py-1.5 tw-px-3 tw-rounded-lg tw-items-center tw-justify-center tw-text-sm tw-font-medium  hover:tw-text-white tw-text-black">
                                                           <svg aria-hidden="true" class="tw-size-5 tw-hidden md:tw-block" xmlns="http://www.w3.org/2000/svg"
                                                               viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                                               stroke-linecap="round" stroke-linejoin="round">
                                                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                               <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                               <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                               <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                               <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                           </svg>
                                                           @lang('sale.pos_sale')
                                                       </a>
                                                   @endcan
                                               @endif
                       -->
                        <!--

                        @if (Module::has('Repair'))
                                                    @includeIf('repair::layouts.partials.header')
                                                @endif
                                                @can('profit_loss_report.view')
                                                    <button type="button" type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        class="tw-hidden sm:tw-inline-flex tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-text-black hover:tw-text-white tw-transition-all tw-duration-200 tw-p-1.5 tw-rounded-lg">
                                                        <span class="tw-sr-only">
                                                            Today's Profit
                                                        </span>
                                                        <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                            <path d="M3 6m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                            <path d="M18 12l.01 0" />
                                                            <path d="M6 12l.01 0" />
                                                        </svg>
                                                    </button>
                                                @endcan
                        -->

                        <button type="button" class="tw-hidden lg:tw-inline-flex
                            class="tw-hidden lg:tw-inline-flex tw-transition-all tw-duration-200  tw-py-1.5 tw-px-3 tw-rounded-lg tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-text-black hover:tw-text-white tw-font-mono">
                            {{ \Carbon\Carbon::now()->format('d M, Y') }}
                        </button>


                     <!-- Select Location -->
                     <div class="tw-flex tw-items-center tw-gap-3">
                                                   <button class="tw-hidden lg:tw-inline-flex tw-items-center tw-gap-1 hover:tw-text-gray-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-size-4"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 21s-6-5.33-6-10a6 6 0 1 1 12 0c0 4.67-6 10-6 10z"/>
                                                            <circle cx="12" cy="11" r="2"/>
                                                        </svg>
                                                        <span>Select location</span>
                                                    </button>

                                                    <!-- Date Range -->
                                                    <button class="tw-hidden lg:tw-inline-flex tw-items-center tw-gap-1 hover:tw-text-gray-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-size-4"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                                        </svg>
                                                        <span>12 Jan – 18 Jan, 2026</span>
                                                    </button>




                                                <button class="tw-p-2 hover:tw-text-gray-900">
                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-size-5"
                                                                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                                                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                                                                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                                                                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                                                                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                                                                                    </svg>
                                                                                                </button>



                                                @if (Module::has('Essentials'))
                                                    @includeIf('essentials::layouts.partials.header_part')
                                                @endif

                                             @include('layouts.partials.header-notifications')


                                             </div>




                    <!--

                     <details class="tw-dw-dropdown tw-relative tw-inline-block tw-text-left">


                                                                    <summary data-toggle="popover"
                                                                                            class="tw-dw-m-1 tw-inline-flex tw-transition-all  header-btn  tw-cursor-pointer tw-duration-200 tw-py-1.5 tw-px-3 tw-rounded-lg tw-items-center tw-justify-center tw-text-sm tw-font-medium hover:tw-text-white tw-gap-1">
                                                                                            <span class="tw-hidden md:tw-block">{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</span>

                                                                                            <svg  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="tw-size-5"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>



                                                                                        </summary>

                                                                        <ul class="tw-p-2 tw-w-48 tw-absolute tw-right-0 tw-z-10 tw-mt-2 tw-origin-top-right tw-bg-white tw-rounded-lg tw-shadow-lg tw-ring-1 tw-ring-gray-200 focus:tw-outline-none"
                                                                            role="menu" tabindex="-1">
                                                                            <div class="tw-px-4 tw-pt-3 tw-pb-1" role="none">
                                                                                <p class="tw-text-sm" role="none">
                                                                                    @lang('lang_v1.signed_in_as')
                                                                                </p>
                                                                                <p class="tw-text-sm tw-font-medium tw-text-gray-900 tw-truncate" role="none">
                                                                                    {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}
                                                                                </p>
                                                                            </div>
                                                                            <li>
                                                                                <a href="{{ action([\App\Http\Controllers\UserController::class, 'getProfile']) }}"
                                                                                    class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-gray-900 hover:tw-bg-gray-100"
                                                                                    role="menuitem" tabindex="-1">
                                                                                    <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                                                                    </svg>
                                                                                    @lang('lang_v1.profile')
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}"
                                                                                    class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg hover:tw-text-gray-900 hover:tw-bg-gray-100"
                                                                                    role="menuitem" tabindex="-1">
                                                                                    <svg aria-hidden="true" class="tw-w-5 tw-h-5" xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" fill="none"
                                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                        <path
                                                                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                                                                        <path d="M9 12h12l-3 -3" />
                                                                                        <path d="M18 15l3 -3" />
                                                                                    </svg>
                                                                                    @lang('lang_v1.sign_out')
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </details>
                    -->



                    </div>
                </div>

    </div>
</div>

<script>
     document.getElementById('mobileSidebarToggle')
        ?.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-collapse');
        });

</script>


<style>

    @media (max-width:1024px){

    .main-sidebar{
        transform: translateX(-100%);
        transition: transform .25s ease;
    }

    body:not(.sidebar-collapse) .main-sidebar{
        transform: translateX(0);
    }

    }
    </style>



