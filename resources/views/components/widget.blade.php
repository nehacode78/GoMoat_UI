<!--
    <div class="{{$class ?? ''}} tw-mb-4 tw-transition-all lg:tw-col-span-2 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md  tw-ring-gray-200"
        @if (!empty($id)) id="{{ $id }}" @endif>
        <div class="tw-p-2 sm:tw-p-3" style="background-color:#F7F7F7;">
            @if (empty($header))
                @if (!empty($title) || !empty($tool))
                    <div class="box-header">
                        {!! $icon ?? '' !!}
                        <h3 class="box-title">{{ $title ?? '' }}</h3>
                        {!! $tool ?? '' !!}

                        @if (isset($help_text))
                            <br />
                            <small>{!! $help_text !!}</small>
                        @endif
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
    -->




<div class="{{ $class ?? '' }} tw-mb-6 tw-px-3 tw-mt-4 tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm" style="background-color:#F7F7F7;"
    @if (!empty($id)) id="{{ $id }}" @endif>

    @if (!empty($title) || !empty($tool))
        <div class="tw-flex tw-items-center tw-mt-4 tw-justify-between tw-px-6 tw-py-5 tw-border-gray-200" style='padding-bottom:20px;'>

           <div class="tw-flex tw-items-center tw-gap-3"  >
               {!! $icon ?? '' !!}
               <h3 class="tw-text-[12px] tw-font-bold tw-m-0" style="color:#333333; font-size: 16px; font-weight:700; ">
                   {{ $title ?? '' }}
               </h3>
           </div>

            <div>
                {!! $tool ?? '' !!}
            </div>

        </div>
    @endif

    <div class="tw-px-6 tw-py-4">
        {{ $slot }}
    </div>

</div>








