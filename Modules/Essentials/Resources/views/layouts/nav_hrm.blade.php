@if(request()->segment(1) == 'hrm')

@php
    $currentPage = ucfirst(str_replace('-', ' ', request()->segment(2)));

    if(empty(request()->segment(2))){
        $currentPage = 'Dashboard';
    }
@endphp

<div class="tw-flex tw-items-center tw-justify-between tw-mx-[16px] tw-mt-6"
     style="margin-left:40px; margin-bottom:24px; padding-top:9px; margin-right:18px;">

    <!-- Left Side (Breadcrumb) -->
    <div class="tw-text-xl tw-font-semibold">
        <span class="tw-text-gray-400">HRM</span>
        <span class="tw-mx-2 tw-text-gray-300">|</span>
        <span class="tw-text-gray-900">{{ $currentPage }}</span>
    </div>

    <!-- Right Side (Date) -->

  @if(request()->segment(2) !== null && request()->segment(2) !== 'dashboard')
      <div class="tw-text-sm tw-px-3 tw-text-gray-400">
          {{ \Carbon\Carbon::now()->format('d M, Y') }}
      </div>
  @endif


</div>


@endif

@if(
    request()->segment(1) == 'hrm' &&
    in_array(request()->segment(2), ['leave', 'leave-type', 'holiday'])
)
<section class="no-print tw-mx-[16px] tw-mb-6">

    <div class="tw-relative tw-border-b tw-border-gray-300 tw-mx-[16px]" style='margin-left: 24px; margin-right: 24px;' >

        <ul class="tw-flex tw-gap-12 tw-text-sm tw-font-semibold tw-uppercase tw-tracking-wider">

            <li>
                <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveController::class, 'index'])}}"
                   class="tab-link {{ request()->segment(2) == 'leave' ? 'active-tab' : '' }}">
                    LEAVE
                </a>
            </li>

            <li>
                <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveTypeController::class, 'index'])}}"
                   class="tab-link {{ request()->segment(2) == 'leave-type' ? 'active-tab' : '' }}">
                    LEAVE TYPE
                </a>
            </li>

            <li>
                <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsHolidayController::class, 'index'])}}"
                   class="tab-link {{ request()->segment(2) == 'holiday' ? 'active-tab' : '' }}">
                    HOLIDAY
                </a>
            </li>

        </ul>

    </div>

</section>
@endif


<style>
.tab-link {
    position: relative;
    padding: 14px 30px;
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Hover Effect */
.tab-link:hover {
    color: #15803d;
}

/* Active Text */
.tab-link.active-tab {
    color: #166534;
}

/* Bottom Moving Green Line */
.tab-link.active-tab::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: #166534;
    border-radius: 2px;
}

</style>



