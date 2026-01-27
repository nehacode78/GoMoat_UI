@inject('request', 'Illuminate\Http\Request')

@if (
    $request->segment(1) == 'pos' &&
        ($request->segment(2) == 'create' || $request->segment(3) == 'edit' || $request->segment(2) == 'payment'))
    @php
        $pos_layout = true;
    @endphp
@else
    @php
        $pos_layout = false;
    @endphp
@endif

@php
    $whitelist = ['127.0.0.1', '::1'];
@endphp

<!DOCTYPE html>
<html class="tw-bg-white tw-scroll-smooth" lang="{{ app()->getLocale() }}"
    dir="{{ in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr' }}">
<head>


     <script>
          if (localStorage.getItem("upos_sidebar_collapse") === "true") {
              document.documentElement.classList.add("sidebar-collapse");
          }
      </script>

    <!-- Tell the browser to be responsive to screen width -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') - {{ Session::get('business.name') }}</title>


    <style>
    /* ================= GLOBAL HEADER (HOME-LIKE) ================= */

    /* ================= GLOBAL HEADER (HOME-LIKE) ================= */

    .global-white-header .tw-bg-gradient-to-r {
        background-color: #ffffff !important;
        background-image: none !important;
    }

    .global-white-header .tw-border-primary-500\/30 {
        border-color: #e5e7eb !important;
    }

    .global-white-header h1,
    .global-white-header .welcome-text {
        color: #19267a !important;
    }

.global-white-header .welcome-text {
    color: #000000 !important;
}


    /* Header icons = WHITE */
    .global-white-header .tw-bg-gradient-to-r svg {
        color: #ffffff !important;
    }

    /* Dropdown icons = DARK */
    .global-white-header .tw-bg-gradient-to-r .tw-bg-white svg {
        color: #0f172a !important;
    }

    </style>







<style>
    .tw-dw-btn.btn-brand {
        background-color: #19267a !important;
    }
    .tw-dw-btn.btn-brand:hover {
        background-color: #141d5a !important;
    }

    </style>



    <style>
    /* Sidebar background */
    .thetop > aside.side-bar {
        background-color: #19267a !important;
    }

    /* Sidebar text */
    .thetop > aside.side-bar,
    .thetop > aside.side-bar a,
    .thetop > aside.side-bar span,
    .thetop > aside.side-bar i {
        color: #ffffff !important;
    }

    /* Hover */
    .thetop > aside.side-bar a:hover {
        background-color: #ffffff1a !important;
    }

 /* Sidebar menu text uppercase */
    .side-bar a,
    .side-bar span,
    .side-bar p,
    .side-bar li {
        text-transform: uppercase;
    }

    </style>



    <style>
    /* ================= ACTIVE SUBMENU DOT (ONLY SUBMENU) ================= */

    /* Target ONLY submenu items */
    .side-bar .panel-collapse ul.nav.navbar-nav li > a {
        position: relative;
        padding-left: 2.5rem;
    }

    /* Dot hidden by default */
    .side-bar .panel-collapse ul.nav.navbar-nav li > a::before {
        content: '';
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: transparent;
        transition: background-color 0.2s ease;
    }

    /* Show dot ONLY on active submenu */
    .side-bar .panel-collapse ul.nav.navbar-nav li.active > a::before {
        background-color: #0ea5e9;
    }

    /* Change TEXT color only (icon untouched) */
    .side-bar .panel-collapse ul.nav.navbar-nav li.active > a span {
        color: #ffffff !important;
    }


    </style>

<style>
  .header-white-bg {
      background: #ffffff !important;
  }

  .header-white-bg {
      transition: none !important;
  }

</style>



    @include('layouts.partials.css')
    

    @include('layouts.partials.extracss')

    @yield('css')

</head>
<body
  class="sidebar-mini tw-font-sans tw-antialiased tw-text-gray-900 tw-bg-gray-100 icons global-white-header
  @if ($pos_layout)
      hold-transition lockscreen
  @else
      hold-transition skin-@if (!empty(session('business.theme_color')))
      {{ session('business.theme_color') }}
      @else
      blue-light
      @endif
  @endif">

    <div class="tw-flex thetop tw-h-screen">

        <script type="text/javascript">
            if (localStorage.getItem("upos_sidebar_collapse") == 'true') {
                var body = document.getElementsByTagName("body")[0];
                body.className += " sidebar-collapse";
            }
        </script>
        @if (!$pos_layout && $request->segment(1) != 'customer-display')
            @include('layouts.partials.sidebar')
        @endif

        @if (in_array($_SERVER['REMOTE_ADDR'], $whitelist))
            <input type="hidden" id="__is_localhost" value="true">
        @endif

        <!-- Add currency related field-->
        <input type="hidden" id="__code" value="{{ session('currency')['code'] }}">
        <input type="hidden" id="__symbol" value="{{ session('currency')['symbol'] }}">
        <input type="hidden" id="__thousand" value="{{ session('currency')['thousand_separator'] }}">
        <input type="hidden" id="__decimal" value="{{ session('currency')['decimal_separator'] }}">
        <input type="hidden" id="__symbol_placement" value="{{ session('business.currency_symbol_placement') }}">
        <input type="hidden" id="__precision" value="{{ session('business.currency_precision', 2) }}">
        <input type="hidden" id="__quantity_precision" value="{{ session('business.quantity_precision', 2) }}">
        <!-- End of currency related field-->
        @can('view_export_buttons')
            <input type="hidden" id="view_export_buttons">
        @endcan
        @if (isMobile())
            <input type="hidden" id="__is_mobile">
        @endif
        @if (session('status'))
            <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
                data-msg="{{ session('status.msg') }}">
        @endif
   <!--  <main class="tw-flex tw-flex-col tw-flex-1 tw-h-full tw-min-w-0 tw-bg-gray-100">-->

 <main id="main-content"
       class="tw-flex tw-flex-col tw-flex-1 tw-h-screen tw-min-w-0 tw-bg-gray-100">



      {{-- HEADER --}}
      @if($request->segment(1) != 'customer-display' && !$pos_layout)
          @include('layouts.partials.header')
      @elseif($request->segment(1) != 'customer-display')
          @include('layouts.partials.header-pos')
      @endif


       <!--

       <button type="button"
                                         class="side-bar-collapse  sidebar-edge-toggle tw-hidden lg:tw-inline-flex tw-items-center tw-justify-center tw-text-sm tw-font-medium tw-text-white tw-transition-all tw-duration-200 tw-bg-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'primary'}}@endif-800 hover:tw-bg-@if(!empty(session('business.theme_color'))){{session('business.theme_color')}}@else{{'primary'}}@endif-700 tw-p-1.5 tw-rounded-lg tw-ring-1 hover:tw-text-white tw-ring-white/10">
                                         <span class="tw-sr-only">
                                             Collapse Sidebar
                                         </span>
                                         <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                             <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                             <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                             <path d="M15 4v16" />
                                             <path d="M10 10l-2 2l2 2" />
                                         </svg>
                                     </button>

       -->


 <button type="button"
   class="sidebar-edge-toggle groww-toggle side-bar-collapse"
   aria-label="Toggle Sidebar"
   style="visibility:hidden">



       <!-- ARROW ICON (OPEN STATE) -->
       <svg class="toggle-arrow" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
           <path d="M15 18l-6-6 6-6"/>
       </svg>



   </button>


      {{-- VUE --}}
      <div id="app">
          @yield('vue')
      </div>

      {{-- SCROLLABLE CONTENT --}}
      <div class="tw-flex-1 tw-overflow-y-auto" id="scrollable-container">
          @yield('content')
      </div>

      {{--  FIXED FOOTER (ONLY HERE) --}}
      @include($pos_layout
          ? 'layouts.partials.footer_pos'
          : 'layouts.partials.footer')

  </main>


        @include('home.todays_profit_modal')
        <!-- /.content-wrapper -->



        <audio id="success-audio">
            <source src="{{ asset('/audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="error-audio">
            <source src="{{ asset('/audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>
        <audio id="warning-audio">
            <source src="{{ asset('/audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
            <source src="{{ asset('/audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
        </audio>

        @if (!empty($__additional_html))
            {!! $__additional_html !!}
        @endif

        @include('layouts.partials.javascripts')
        
        {{-- Module JS --}}
        @include('layouts.module-assets')


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.body.classList.remove('preload');

                const toggle = document.querySelector('.sidebar-edge-toggle');
                if (toggle) {
                    toggle.style.visibility = 'visible';
                }
            });
        </script>

        <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

        @if (!empty($__additional_views) && is_array($__additional_views))
            @foreach ($__additional_views as $additional_view)
                @includeIf($additional_view)
            @endforeach
        @endif
        <div>
            <div class="overlay tw-hidden"></div>
        </div>



</body>
<style>
    @media print {
        #scrollable-container {
            overflow: visible !important;
            height: auto !important;

        }
        
        /* Hide side menu */
        .side-bar,
        .thetop > aside {
            display: none !important;
        }
    }
</style>

<style>
    html, body {
        height: 100%;
        overflow: hidden;
    }

    .small-view-side-active {
        display: grid !important;
        z-index: 1000;
        position: absolute;
    }

    .overlay {
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        position: fixed;
        top: 0;
        left: 0;
        display: none;
        z-index: 20;
    }

    #scrollable-container{
        position:relative;
    }
</style>

<style>
    /* ================= MAIN SIDEBAR TABS → UPPERCASE ONLY ================= */
    .side-bar .sidebar-scroll > div > a > span {
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ================= SUBMENU → NORMAL CASE ================= */
    .side-bar .chiled a span {
        text-transform: none !important;
    }

    </style>


<style>

    /* ================= GROWw-STYLE SIDEBAR EDGE TOGGLE ================= */

   /* ================= TOGGLE — HALF OUTSIDE SIDEBAR, CENTERED ON DIVIDER ================= */

   .sidebar-edge-toggle {
       position: fixed;

       /* Sidebar open width */
       left: 256px;

       /* Center vertically on divider line */
       top: 30px; /* same as .sidebar-brand height */

       transform: translate(-50%, -50%);

       z-index: 99999;

       width: 34px;
       height: 34px;
       border-radius: 9999px;

       background: #ffffff;
       border: 1px solid #e5e7eb;

       display: flex;
       align-items: center;
       justify-content: center;

       box-shadow: 0 6px 16px rgba(0,0,0,0.18);
      transition: transform 0.25s ease, left 0.25s ease;

   }

   /* Sidebar collapsed */
   body.sidebar-collapse .sidebar-edge-toggle {
       left: 64px;
   }


    /* Icon size */
    .sidebar-edge-toggle svg {
      width: 16px;
      height: 16px;
    }

/* 🔒 Prevent SVG from ever scaling */
.sidebar-edge-toggle svg,
.sidebar-edge-toggle svg path {
    vector-effect: non-scaling-stroke !important;
    transform-box: fill-box !important;
    transform-origin: center !important;
}


    /* Hover effect */
    .sidebar-edge-toggle:hover {
      box-shadow: 0 8px 22px rgba(0,0,0,0.25);
      transform: translateX(-50%) scale(1.05);
    }

    /* ================= COLLAPSED STATE ================= */

    body.sidebar-collapse .sidebar-edge-toggle {
      left: 64px;                 /* collapsed sidebar width */
      transform: translateX(-50%);
    }

    /* Flip arrow when collapsed */
    body.sidebar-collapse .sidebar-edge-toggle svg {
      transform: rotate(180deg);
    }

    </style>


<style>
    /* ================= SIDEBAR BASE STYLES ================= */
    .side-bar {
        transition: width 0.3s ease;
    }

    /* ================= COLLAPSED STATE ================= */
    body.sidebar-collapse .side-bar {
        width: 64px !important;
    }

   /* Hide ONLY text, not icons */
   body.sidebar-collapse .sidebar-scroll span {
       opacity: 0;
       visibility: hidden;
       width: 0;
   }

   /* Sidebar must NEVER disappear */
   .side-bar {
       min-width: 64px;
   }

   /* ================= KEEP ICONS VISIBLE WHEN COLLAPSED ================= */
   body.sidebar-collapse .side-bar svg {
       opacity: 1 !important;
       visibility: visible !important;
       width: auto !important;
       height: auto !important;
   }



   /* But keep icons */
   body.sidebar-collapse .sidebar-scroll svg {
       opacity: 1;
       visibility: visible;
   }


    body.sidebar-collapse .side-bar > a {
        justify-content: center !important;
        padding: 1rem 0 !important;
    }

    /* ================= MENU ITEMS ================= */


    /* Center icons when collapsed */
    body.sidebar-collapse .sidebar-scroll a {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Hide dropdown arrows when collapsed */
    body.sidebar-collapse .sidebar-scroll .svg,
    body.sidebar-collapse .sidebar-scroll .fa-angle-down,
    body.sidebar-collapse .sidebar-scroll .fa-chevron-down {
        display: none !important;
    }

    /* Hide all submenus when collapsed */
    body.sidebar-collapse .chiled {
        display: none !important;
    }

    /* Adjust padding when collapsed */
    body.sidebar-collapse .sidebar-scroll {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    /* ================= TOGGLE BUTTON ================= */
    .sidebar-edge-toggle {
        position: fixed;
        top: 120px;
        left: 256px;
        transform: translateX(-50%);
        z-index: 99999;
        width: 34px;
        height: 34px;
        border-radius: 9999px;
        background: #ffffff;
        color: #19267a;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,0.18);
        border: 1px solid #e5e7eb;
    transition: transform 0.25s ease, left 0.25s ease;

        cursor: pointer;
    }

    .sidebar-edge-toggle svg {
        width: 16px;
        height: 16px;
       transition: transform 0.25s ease, left 0.25s ease;

    }

    .sidebar-edge-toggle:hover {
        box-shadow: 0 8px 22px rgba(0,0,0,0.25);
        transform: translateX(-50%) scale(1.05);
    }

    body.sidebar-collapse .sidebar-edge-toggle {
        left: 64px;
    }

    body.sidebar-collapse .sidebar-edge-toggle svg {
        transform: rotate(180deg);
    }



/* ================= ICON-ONLY SIDEBAR (FINAL) ================= */

/* Sidebar width */
.side-bar {
    width: 256px;
    min-width: 64px;
    transition: width 0.3s ease;
}

/* Collapsed width */
body.sidebar-collapse .side-bar {
    width: 64px !important;
}

/* Hide text ONLY */
body.sidebar-collapse .sidebar-scroll span,
body.sidebar-collapse .side-bar-heading {
    opacity: 0;
    visibility: hidden;
    width: 0;
}

/* Icons ALWAYS visible */
body.sidebar-collapse .sidebar-scroll svg {
    opacity: 1 !important;
    visibility: visible !important;
    width: 22px;
    height: 22px;
}

/* Center icons */
body.sidebar-collapse .sidebar-scroll a {
    justify-content: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Hide arrows & submenus */
body.sidebar-collapse .fa-angle-down,
body.sidebar-collapse .fa-chevron-down,
body.sidebar-collapse .chiled {
    display: none !important;
}



/* ================= ADMINLTE ICON-ONLY FIX ================= */

/* Prevent AdminLTE from hiding sidebar */
.sidebar-mini.sidebar-collapse .main-sidebar {
    width: 64px !important;
    min-width: 64px !important;
    overflow: visible !important;
}

/* Keep sidebar visible */
.main-sidebar {
    display: flex !important;
}

/* Hide text only */
.sidebar-mini.sidebar-collapse .sidebar-scroll span,
.sidebar-mini.sidebar-collapse .side-bar-heading {
    opacity: 0;
    visibility: hidden;
    width: 0;
}

/* Icons always visible */
.sidebar-mini.sidebar-collapse .sidebar-scroll svg {
    opacity: 1 !important;
    visibility: visible !important;
    width: 22px;
    height: 22px;
}

/* Center icons */
.sidebar-mini.sidebar-collapse .sidebar-scroll a {
    justify-content: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}


/* ================= CONTENT OFFSET FOR FIXED SIDEBAR ================= */

/* Default (sidebar open) */
#main-content {
    margin-left: 256px;
    transition: margin-left 0.3s ease;
}

/* Collapsed sidebar */
body.sidebar-collapse #main-content {
    margin-left: 64px;
}






/* ================= SIDEBAR BRAND CENTER FIX ================= */

/* ================= SIDEBAR BRAND — MATCH HEADER HEIGHT ================= */

/* ================= SIDEBAR BRAND — MATCH HEADER HEIGHT (FINAL) ================= */

/* ================= SIDEBAR BRAND — COMPACT (FINAL) ================= */

.sidebar-brand {
    height: 56px;              /* REDUCED HEIGHT */
    min-height: 56px;

    display: flex;
    align-items: center;       /* vertical center */
    justify-content: center;

    gap: 8px;
    padding: 0 14px;

    background-color: #19267a;
    color: #ffffff;

    border-bottom: 1px solid rgba(255,255,255,0.25);

    box-sizing: border-box;
    overflow: hidden;
    white-space: nowrap;
}

/* Logo — LOCKED SIZE */
.sidebar-logo-icon,
.sidebar-brand img {
    width: 24px !important;
    height: 24px !important;
    max-width: 24px !important;
    max-height: 24px !important;
    object-fit: contain;
    flex-shrink: 0;
}

/* Brand text */
.sidebar-logo-text {
    font-size: 14.5px;
    font-weight: 600;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Collapse → icon only */
body.sidebar-collapse .sidebar-brand {
    justify-content: center;
}

body.sidebar-collapse .sidebar-logo-text {
    display: none !important;
}





/* ================= GROWW-STYLE SIDEBAR TOGGLE ================= */

.groww-toggle {
    width: 34px;
    height: 34px;
    border-radius: 9999px;

    background: #ffffff;
    border: 1px solid #e5e7eb;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    cursor: pointer;

    transition: all 0.25s ease;
}

/* Arrow icon */
.groww-toggle .toggle-arrow {
    width: 16px;
    height: 16px;
    color: #19267a;
    transition: transform 0.3s ease, opacity 0.2s ease;
}

/* Green dot (hidden by default) */
.groww-toggle .toggle-dot {
    width: 8px;
    height: 8px;
    background-color: #22c55e; /* green */
    border-radius: 9999px;
    display: none;
}

/* Hover */
.groww-toggle:hover {
    box-shadow: 0 8px 22px rgba(0,0,0,0.25);
}

/* ================= COLLAPSED STATE ================= */

body.sidebar-collapse .groww-toggle .toggle-arrow {
    opacity: 0;
    transform: scale(0.6);
}

body.sidebar-collapse .groww-toggle .toggle-dot {
    display: block;
}

/* Rotate arrow when open */
body:not(.sidebar-collapse) .groww-toggle .toggle-arrow {
    transform: rotate(180deg);
}






/* ================= GROWW TOGGLE — ARROW ALWAYS VISIBLE ================= */

.groww-toggle {
    width: 34px;
    height: 34px;
    border-radius: 9999px;
    background: #ffffff;
    border: 1px solid #e5e7eb;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    cursor: pointer;

    transition: all 0.25s ease;
}

/* Arrow — ALWAYS visible & centered */
.groww-toggle .toggle-arrow {
    width: 16px;
    height: 16px;

    color: #19267a;

    opacity: 1 !important;
    visibility: visible !important;

    display: block;

    transition: transform 0.3s ease;
}

/* Sidebar OPEN → arrow points LEFT */
body:not(.sidebar-collapse) .groww-toggle .toggle-arrow {
    transform: rotate(180deg);
}

/* Sidebar CLOSED → arrow points RIGHT */
body.sidebar-collapse .groww-toggle .toggle-arrow {
    transform: rotate(0deg);
}





</style>




<style>
/* ================= HEADER RIGHT TABS — CLEAN STYLE ================= */




/* ================= HEADER CLEAN TABS (FINAL) ================= */

/* ================= HEADER RIGHT TABS — CLEAN (NO BOX) ================= */

.header-white-bg {
    background: #ffffff !important;
}

/* Remove gradient */
.header-white-bg[class*="tw-bg-gradient"] {
    background-image: none !important;
}

/* Buttons / links / summaries */
.header-white-bg button,
.header-white-bg a,
.header-white-bg summary {
    background: transparent !important;
    color: #000000 !important;
    border: none !important;          /* 🔥 removed box */
    box-shadow: none !important;
}

/* Icons visible */
.header-white-bg svg {
    color: #000000 !important;
    stroke: #000000 !important;
    opacity: 1 !important;
}

/* Kill hover effects */
.header-white-bg button:hover,
.header-white-bg a:hover,
.header-white-bg summary:hover {
    background: transparent !important;
    color: #000000 !important;
}

/* Remove Tailwind ring glow */
.header-white-bg [class*="tw-ring"] {
    box-shadow: none !important;
}

/* ================= HEADER RIGHT TEXT SIZE ================= */

/* Text inside header tabs */
.header-white-bg summary,
.header-white-bg a,
.header-white-bg button {
    font-size: 14.5px !important;   /* default was ~12–13px */
    font-weight: 500;
}

/* Optional: make username slightly stronger */
.header-white-bg summary span {
    font-size: 15px !important;
    font-weight: 600;
}

.header-white-bg {
    min-height: 85px;
}


/* ================= SIDEBAR BRAND — COLLAPSED CLEAN ================= */

/* Hide ALL text nodes when collapsed */
body.sidebar-collapse .sidebar-brand *,
body.sidebar-collapse .sidebar-brand span,
body.sidebar-collapse .sidebar-brand h1,
body.sidebar-collapse .sidebar-brand h2,
body.sidebar-collapse .sidebar-brand p {
    display: none !important;
}

/* Keep only logo / svg visible */
body.sidebar-collapse .sidebar-brand svg,
body.sidebar-collapse .sidebar-brand img {
    display: block !important;
    margin: auto;
}

    </style>



<style>

    /* ===== SIDEBAR BRAND ===== */
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        height: 64px;
        overflow: hidden;
        white-space: nowrap;
        margin-top: -40px;

    }

    /* ICON */
/*     .sidebar-logo-icon { */
/*         width: 28px; */
/*         height: 28px; */
/*         flex-shrink: 0; */
/*     } */

/* ===== FIX: Prevent sidebar logo resize on page load ===== */

.sidebar-brand img,
.sidebar-logo-icon {
    width: 28px !important;
    height: 28px !important;
    max-width: 28px !important;
    max-height: 28px !important;
    object-fit: contain;
}



/* Prevent logo reflow before sidebar-collapse is applied */
body.sidebar-mini .sidebar-brand img {
    transform: scale(1) !important;
}


    /* TEXT */
    .sidebar-logo-text {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    /* Green dot */
    .sidebar-logo-text .status-dot {
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
    }

    </style>


<style>
    /* ================= HEADER BUTTONS — NO FLASH ================= */

    .header-white-bg .header-btn {
        background: transparent !important;
        color: #000000 !important;
        border: none !important;
        box-shadow: none !important;
        transition: none !important;
    }

    .header-white-bg .header-btn svg {
        color: #000000 !important;
        stroke: #000000 !important;
    }

    /* Hover (optional subtle effect) */
    .header-white-bg .header-btn:hover {
        background: rgba(0,0,0,0.04);
    }

    </style>


</html>
