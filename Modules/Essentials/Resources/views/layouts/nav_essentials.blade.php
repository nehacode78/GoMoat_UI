<!--

    <section class="no-print">
        <nav class="navbar-default tw-transition-all tw-duration-5000 tw-shrink-0 tw-rounded-2xl tw-m-[16px] tw-border-2 !tw-bg-white">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="margin-top: 3px; margin-right: 3px;">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'index'])}}"><i class="fas fa-check-circle"></i> {{__('essentials::lang.essentials')}}</a>
                </div>


                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li @if(request()->segment(2) == 'todo') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'index'])}}">@lang('essentials::lang.todo')</a></li>

                        <li @if(request()->segment(2) == 'document' && request()->get('type') != 'memos') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\DocumentController::class, 'index'])}}">@lang('essentials::lang.document')</a></li>
                        <li @if(request()->segment(2) == 'document' && request()->get('type') == 'memos') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\DocumentController::class, 'index']) .'?type=memos'}}">@lang('essentials::lang.memos')</a></li>


                        <li @if(request()->segment(2) == 'reminder') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\ReminderController::class, 'index'])}}">@lang('essentials::lang.reminders')</a></li>
                        @if (auth()->user()->can('essentials.view_message') || auth()->user()->can('essentials.create_message'))
                            <li @if(request()->segment(2) == 'messages') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsMessageController::class, 'index'])}}">@lang('essentials::lang.messages')</a></li>
                        @endif
                        <li @if(request()->segment(2) == 'knowledge-base') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'index'])}}">@lang('essentials::lang.knowledge_base')</a></li>
                        @if (auth()->user()->can('edit_essentials_settings'))
                            <li @if(request()->segment(2) == 'hrm' && request()->segment(2) == 'settings') class="active" @endif><a href="{{action([\Modules\Essentials\Http\Controllers\EssentialsSettingsController::class, 'edit'])}}">@lang('business.settings')</a></li>
                        @endif
                    </ul>

                </div>
            </div>
        </nav>
    </section>
    -->



@if(request()->segment(1) == 'essentials')

@php
    $segment = request()->segment(2);

    if($segment == 'document' && request()->get('type') == 'memos'){
        $currentPage = 'Memos';
    } else {
        $currentPage = $segment
            ? ucwords(str_replace('-', ' ', $segment))
            : 'Dashboard';
    }
@endphp

<div class="tw-flex tw-items-center tw-justify-between tw-mx-[16px] tw-mt-6"
     style="margin-left:40px; margin-bottom:24px; padding-top:9px; margin-right:18px;">

    <div class="tw-text-xl tw-font-semibold">
        <span class="tw-text-gray-400">Essentials</span>
        <span class="tw-mx-2 tw-text-gray-300">|</span>
        <span class="tw-text-gray-900">{{ $currentPage }}</span>
    </div>

    <div class="tw-flex tw-items-center tw-gap-6">

        @if(request()->segment(2) !== null)
            <div class="tw-text-sm tw-text-gray-400">
                {{ \Carbon\Carbon::now()->format('d M, Y') }}
            </div>
        @endif

    </div>

</div>

@endif