
    <div class="{{$class ?? ''}} tw-mb-4 tw-transition-all lg:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md  tw-ring-gray-200"
        @if (!empty($id)) id="{{ $id }}" @endif>
        <div class="tw-p-2 sm:tw-p-3" style="background-color:#F7F7F7;">
            @if (empty($header))
                @if (!empty($title) || !empty($tool))

                    <div class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-3">

                        {{-- LEFT SIDE --}}
                        <div class="tw-flex tw-items-center tw-gap-2">
                            {!! $icon    ?? '' !!}
                            <h3 class="box-title tw-m-0 tw-font-semibold tw-text-base">
                                {{ $title ?? '' }}
                            </h3>
                        </div>

                        {{-- RIGHT SIDE --}}
                        <div>
                            {!! $tool ?? '' !!}
                        </div>

                    </div>

                @endif
            @else
                <div class="box-header">
                    {!! $header !!}
                </div>
            @endif
            <div class="tw-flow-root tw-border-gray-200">
                <div class="">
                    <div class="tw-py-2 tw-align-middle sm:tw-px-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>














