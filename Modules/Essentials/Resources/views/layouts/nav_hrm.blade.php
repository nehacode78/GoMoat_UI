@if(request()->segment(1) == 'hrm')

@php
    $currentPage = ucfirst(str_replace('-', ' ', request()->segment(2)));

    if(empty(request()->segment(2))){
        $currentPage = 'Dashboard';
    }
@endphp

<div class="tw-mx-[16px] tw-mt-6 tw-text-xl tw-font-semibold" style="margin-left: 40px; margin-bottom: 24px; padding-top: 9px; ">
    <span class="tw-text-gray-400">HRM</span>
    <span class="tw-mx-2 tw-text-gray-300">|</span>
    <span class="tw-text-gray-900">{{ $currentPage }}</span>
</div>

@endif

@if(
    request()->segment(1) == 'hrm' &&
    in_array(request()->segment(2), ['leave', 'leave-type', 'holiday'])
)
<section class="no-print">
    <nav class="navbar-default tw-transition-all tw-duration-5000 tw-shrink-0 tw-rounded-2xl tw-m-[16px] tw-border-2 !tw-bg-white">

        <div class="container-fluid">
            <div class="collapse navbar-collapse tw-text-gray-400">
                <ul class="nav navbar-nav">

                    @if(auth()->user()->can('essentials.crud_all_leave') || auth()->user()->can('essentials.crud_own_leave'))
                        <li @if(request()->segment(2) == 'leave') class="active" @endif>
                            <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveController::class, 'index'])}}">
                                @lang('essentials::lang.leave')
                            </a>
                        </li>
                    @endif

                    @can('essentials.crud_leave_type')
                        <li @if(request()->segment(2) == 'leave-type') class="active" @endif>
                            <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsLeaveTypeController::class, 'index'])}}">
                                @lang('essentials::lang.leave_type')
                            </a>
                        </li>
                    @endcan

                    <li @if(request()->segment(2) == 'holiday') class="active" @endif>
                        <a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsHolidayController::class, 'index'])}}">
                            @lang('essentials::lang.holiday')
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</section>
@endif

