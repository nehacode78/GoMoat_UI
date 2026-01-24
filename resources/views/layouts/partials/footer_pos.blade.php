<!-- Main Footer -->
<footer class="app-footer-fixed app-footer-pos no-print">
    <small>
        <b>
            {{ config('app.name', 'ultimatePOS') }}
            - V{{ config('author.app_version') }}
            | Copyright &copy; {{ date('Y') }} All rights reserved.
        </b>
    </small>
</footer>



<div class="tw-flex-1 tw-overflow-y-auto" id="scrollable-container">
    @yield('content')

    @if (!$pos_layout)
        @include('layouts.partials.footer')
    @else
        @include('layouts.partials.footer_pos')
    @endif
</div>
