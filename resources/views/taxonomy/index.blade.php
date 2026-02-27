
@extends('layouts.app')
@php
    $heading = !empty($module_category_data['heading']) ? $module_category_data['heading'] : __('category.categories');
    $navbar = !empty($module_category_data['navbar']) ? $module_category_data['navbar'] : null;
@endphp
@section('title', $heading)

@section('content')
    @if (!empty($navbar))
        @include($navbar)
    @endif

    <!--

        <section class="content-header">
            <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black" >{{ $heading }}
                <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold" >
                    {{ $module_category_data['sub_heading'] ?? __('category.manage_your_categories') }}
                </small>
                @if (isset($module_category_data['heading_tooltip']))
                    @show_tooltip($module_category_data['heading_tooltip'])
                @endif
            </h1>

        </section>

    -->

    <!-- Main content -->
    <section class="content">

        @php
            $cat_code_enabled =
                isset($module_category_data['enable_taxonomy_code']) && !$module_category_data['enable_taxonomy_code']
                    ? false
                    : true;
        @endphp
        <input type="hidden" id="category_type" value="{{ request()->get('type') }}">
        @php
            $can_add = true;
            if (request()->get('type') == 'product' && !auth()->user()->can('category.create')) {
                $can_add = false;
            }
        @endphp

       @component('components.widget', [
           'class' => 'box-solid',
           'can_add' => $can_add,
           'title' => request()->get('type') == 'hrm_designation'
               ? 'Manage Designations'
               : 'Manage Departments',
           'icon' => '<i class="fas fa-layer-group tw-text-gray-600 tw-text-sm"></i>'
        ])

            @if ($can_add)
                @slot('tool')
                    <div class="tw-flex tw-items-center">
                        <a class="tw-inline-flex tw-items-center tw-gap-2
                            tw-text-white tw-text-sm tw-font-medium tw-px-4 tw-py-2 tw-rounded-md btn-modal"
                            style="background-color:#2B7ADA;"
                            data-href="{{action([\App\Http\Controllers\TaxonomyController::class, 'create'])}}?type={{request()->get('type')}}"
                            data-container=".category_modal">

                            <i class="fas fa-plus-circle tw-text-xs"></i>

                            {{ request()->get('type') == 'hrm_designation'
                                ? 'Add Designation'
                                : 'Add Department' }}
                        </a>
                    </div>
                @endslot


            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="category_table">
                    <thead>
                        <tr>
                            <th>
                                @if (!empty($module_category_data['taxonomy_label']))
                                    {{ $module_category_data['taxonomy_label'] }}
                                @else
                                    @lang('category.category')
                                @endif
                            </th>
                            @if ($cat_code_enabled)
                                <th>{{ $module_category_data['taxonomy_code_label'] ?? __('category.code') }}</th>
                            @endif
                            <th>@lang('lang_v1.description')</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcomponent

        <div class="modal fade category_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>


    </section>
    <!-- /.content -->
@stop
@section('javascript')
    @includeIf('taxonomy.taxonomies_js')
@endsection

<style>
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
    </style>



<style>
/* Make widget header flex */
.box.box-solid > .box-header {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 16px 20px !important;
}

/* Left title alignment */
.box.box-solid > .box-header .box-title {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-weight: 600;
    font-size: 15px;
    margin: 0 !important;
}

/* Push button fully right */
.box.box-solid > .box-header .box-tools {
    margin-left: auto !important;
}
</style>









