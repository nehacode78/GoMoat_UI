@if(
    request()->segment(1) == 'hrm' ||
    in_array(request()->get('type'), ['hrm_department', 'hrm_designation'])
)

@php
    if(request()->get('type') == 'hrm_department'){
        $currentPage = 'Departments';
    } elseif(request()->get('type') == 'hrm_designation'){
        $currentPage = 'Designations';
    } else {
        $segment = request()->segment(2);
        $currentPage = $segment
            ? ucwords(str_replace('-', ' ', $segment))
            : 'Dashboard';
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
  <div class="tw-flex tw-items-center tw-gap-6">

      {{-- Date --}}
    @if(
        (request()->segment(1) == 'hrm' && request()->segment(2) !== 'dashboard')
        ||
        in_array(request()->get('type'), ['hrm_department', 'hrm_designation'])
    )
        <div class="tw-text-sm tw-text-gray-400">
            {{ \Carbon\Carbon::now()->format('d M, Y') }}
        </div>
    @endif

     {{-- Show Update Settings ONLY on settings page --}}
        @if(request()->segment(2) == 'settings')
            <button type="submit"
                form="essentials_settings_form"
                class="hover:tw-bg-[#1f5bd8]
                       tw-text-white tw-rounded-md
                       tw-px-5 tw-py-2 tw-text-sm tw-font-medium" style="background-color:#2B7ADA;">
                Update Settings
            </button>
        @endif

      {{-- Show Clock In ONLY on attendance page --}}
      @if(request()->segment(2) == 'attendance')

          @php
              $clock_in = \Modules\Essentials\Entities\EssentialsAttendance::where('user_id', auth()->id())
                          ->whereDate('clock_in_time', now())
                          ->whereNull('clock_out_time')
                          ->first();
          @endphp

          <button
              type="button"
              class="tw-ml-4
                     tw-bg-[#2B7ADA] hover:tw-bg-[#1f5bd8]
                     tw-text-white tw-rounded-md
                     tw-px-4 tw-py-2 tw-text-sm tw-font-medium
                     clock_in_btn
                     {{ !empty($clock_in) ? 'hide' : '' }}" style="background-color: #2B7ADA !important;"
              data-type="clock_in">

              <i class="fas fa-arrow-circle-down tw-mr-1"></i>
              Clock In
          </button>

          <button
              type="button"
              class="tw-ml-4
                     tw-bg-yellow-500 hover:tw-bg-yellow-600
                     tw-text-white tw-rounded-md
                     tw-px-4 tw-py-2 tw-text-sm tw-font-medium
                     clock_out_btn
                     {{ empty($clock_in) ? 'hide' : '' }}"
              data-type="clock_out">

              <i class="fas fa-hourglass-half tw-mr-1"></i>
              Clock Out
          </button>

      @endif

  </div>

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
    .tw-text-xl{
    font-size:24px;
    }
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



<style>
    .tab-link {
        position: relative;
        padding: 14px 30px;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tab-link:hover {
        color: #15803d;
    }

    .tab-link.active-tab {
        color: #166534;
    }

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



