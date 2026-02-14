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

     <!--

     <script>
               if (localStorage.getItem("upos_sidebar_collapse") === "true") {
                   document.documentElement.classList.add("sidebar-collapse");
               }
           </script>
     -->

 <script>
 (function() {
     const c = localStorage.getItem("upos_sidebar_collapse") === "true";
     if (c) document.documentElement.classList.add("sidebar-collapse");
     document.documentElement.classList.add("preload");
 })();
 </script>

 <script>
 (function() {
     const criticalCSS = document.createElement('style');
     criticalCSS.textContent = `
         .sidebar-brand {
             margin-top: -34px !important;
             height: 56px !important;
         }
         .sidebar-brand img {
             width: 28px !important;
             height: 28px !important;
         }
     `;
     document.head.insertBefore(criticalCSS, document.head.firstChild);
 })();
 </script>



    <!-- Tell the browser to be responsive to screen width -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ Session::get('business.name') }}</title>

    <style>
    body.preload *{animation-duration:0s!important;transition-duration:0s!important}
    .sidebar-brand{height:56px!important;margin-top:-34px!important;min-height:56px!important}
    .sidebar-brand img{width:28px!important;height:28px!important;max-width:28px!important;object-fit:contain!important}
    .side-bar{width:256px!important}
    body.sidebar-collapse .side-bar{width:64px!important}
    #main-content{margin-left:256px!important}
    body.sidebar-collapse #main-content{margin-left:64px!important}
    </style>

<style>
    /* Toggle button - VISIBLE AND POSITIONED FROM START */
    .sidebar-edge-toggle{
        position: fixed !important;
        left: 244px !important;
        top: 67px !important;
        /* ... other styles ... */
        opacity: 1 !important;           // ← VISIBLE
        visibility: visible !important;  // ← VISIBLE
    }
    </style>

    <style>
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

        .thetop {
            overflow: hidden !important;
        }

    /* Sidebar background */
    .thetop > aside.side-bar {
        background-color: #F7F7F7 !important;
    }

    /* Sidebar text */
    .thetop > aside.side-bar,
    .thetop > aside.side-bar a,
    .thetop > aside.side-bar span,
    .thetop > aside.side-bar i {
        color: rgb(105 117 134/var(--tw-text-opacity)) !important;
    }

    /* Hover */
    .thetop > aside.side-bar a:hover {
        background-color: #ffffff1a !important;
    }

 /* MAIN sidebar menu → UPPERCASE only */
 .side-bar > .sidebar-scroll > ul > li > a > span {
     text-transform: uppercase;
     letter-spacing: 0.04em;
 }
 /* Submenu text → normal case */
 .side-bar .chiled a span,
 .side-bar .panel-collapse a span {
     text-transform: none !important;
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


<style>
/* Prevent old input flash */
.preload input,
.preload textarea,
.preload select,
.preload .form-control {
    visibility: hidden;
}
</style>


<style>
  /* ===== CRITICAL SIDEBAR BRAND — PREVENT LOAD SHIFT ===== */

  .sidebar-brand {
      height: 56px;
      min-height: 56px;
      max-height: 56px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 0 14px;
      background-color: #F7F7F7;
      box-sizing: border-box;
      overflow: hidden;
      white-space: nowrap;
  }

  .sidebar-brand img {
      width: 24px;
      height: 24px;
      max-width: 24px;
      max-height: 24px;
      object-fit: contain;
      flex-shrink: 0;
  }

  .sidebar-logo-text {
      font-size: 14.5px;
      font-weight: 600;
      line-height: 1;
      display: inline-flex;
      align-items: center;
      gap: 6px;
  }
</style>

    <style>
        :root {
            --sidebar-width: 256px; /* OPEN */
        }

        body.sidebar-collapse {
            --sidebar-width: 64px; /* COLLAPSED */
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

    <div class="tw-flex thetop">

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

<!-- groww-toggle-->
 <button type="button"
   class="sidebar-edge-toggle side-bar-collapse"
   aria-label="Toggle Sidebar"
   style="">
       <!-- ARROW ICON(OPEN STATE) -->
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
      <div class="tw-flex-1 whitish" id="scrollable-container">
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


        <!--

        <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.body.classList.remove('preload');

                        const toggle = document.querySelector('.sidebar-edge-toggle');
                        if (toggle) {
                            toggle.style.visibility = 'visible';
                        }
                    });
                </script>
        -->

    <script>
   window.addEventListener('load', function () {
       requestAnimationFrame(() => {
           document.documentElement.classList.remove("preload");
           document.body.classList.remove("preload");
       });
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


    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const toggle = document.getElementById("sidebarUserToggle");
        const card = document.getElementById("sidebarUserCard");

        if(toggle && card){
            toggle.addEventListener("click", function (e) {
                e.stopPropagation();
                card.style.display = card.style.display === "block" ? "none" : "block";
            });

            document.addEventListener("click", function () {
                card.style.display = "none";
            });
        }
    });
    </script>




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

/*     #scrollable-container{ */
/*         position:relative; */
/*     } */

#scrollable-container {
    position: relative;
    overflow-y: auto;
    height: calc(100vh - 85px - 36px); /* viewport - header - footer */
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
    /* ================= SIDEBAR BASE STYLES ================= */

   body.sidebar-collapse .side-bar {
       width: 64px;
       min-width: 64px;
   }



   /* Hide ONLY text, not icons */
   body.sidebar-collapse .sidebar-scroll span {
       opacity: 0;
       visibility: hidden;
       width: 0;
   }


   /* ================= KEEP ICONS VISIBLE WHEN COLLAPSED ================= */
/*    body.sidebar-collapse .side-bar svg { */
/*        opacity: 1 !important; */
/*        visibility: visible !important; */
/*        width: auto !important; */
/*        height: auto !important; */
/*    } */

body.sidebar-collapse .sidebar-scroll a svg {
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
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }


body.sidebar-collapse .sidebar-edge-toggle svg {
    transform: rotate(180deg);
}



/* ================= SYNCHRONIZED SIDEBAR & TOGGLE ANIMATION ================= */

/* Sidebar and toggle animate together */
.side-bar,
.sidebar-edge-toggle {
    transition: transform 0.3s ease;
}

/* Default state - sidebar open */
.side-bar {
    transform: translateX(0);
}



/* Collapsed state - sidebar hidden */
body.sidebar-collapse .side-bar {
    transform: translateX(-192px);  /* move sidebar left */
}

/* Arrow rotation */
body.sidebar-collapse .sidebar-edge-toggle svg {
    transform: rotate(180deg);
}

/* Main content adjustment */

#main-content {
    margin-left: 256px;
    transition: margin-left 0.3s ease;
}

#main-content {
    margin-left: 256px;
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    transition: margin-left 0.3s ease;
    width: calc(100% - 256px);  /* Explicit width */
}


body.sidebar-collapse #main-content {
    margin-left: 64px;
    width: calc(100% - 64px);  /* Adjust width when collapsed */
}

.side-bar {
    width: 256px;
    min-width: 256px;
    height: 100vh;
    position: fixed;

    overflow: visible !important;
    top: 0;
    left: 0;
/*     overflow: hidden; */
    transition: transform 0.3s ease;
    transform: translateX(0);
    z-index: 1000;
    background-color: #19267a !important;
}


.sidebar-edge-toggle {
/*     position: fixed; */
/*     left: 244px; */
/*     top: 67px; */
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1001;
    cursor: pointer;
    box-shadow: 0 6px 16px rgba(0,0,0,0.18);
     transform: translateX(0);
     transition: left 0.3s ease, transform 0.3s ease;

}




/* Toggle moves when sidebar collapses */
body.sidebar-collapse .sidebar-edge-toggle {
    left: 56px;  /* 64px collapsed width - 8px offset */
}

/* Toggle arrow rotation */
.sidebar-edge-toggle svg,
.groww-toggle .toggle-arrow {
    width: 16px;
    height: 16px;
    color: #19267a;
    transition: transform 0.3s ease;
}

/* Arrow points LEFT when sidebar is OPEN */
body:not(.sidebar-collapse) .sidebar-edge-toggle svg,
body:not(.sidebar-collapse) .groww-toggle .toggle-arrow {
    transform: rotate(180deg);
}

/* Arrow points RIGHT when sidebar is CLOSED */
body.sidebar-collapse .sidebar-edge-toggle svg,
body.sidebar-collapse .groww-toggle .toggle-arrow {
    transform: rotate(0deg);
}

/* ================= FIX: Toggle must follow sidebar strip ================= */

/* OPEN sidebar → toggle at full sidebar edge */
body:not(.sidebar-collapse) .sidebar-edge-toggle {
    left: 256px !important;   /* sidebar open width */
    transform: translateX(-50%);
}

/* COLLAPSED sidebar → toggle on visible strip */
body.sidebar-collapse .sidebar-edge-toggle {
    left: 64px !important;    /* sidebar strip width */
    transform: translateX(-50%);
}


/* Main content adjustment */
#main-content {
    margin-left: 256px;
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    transition: margin-left 0.3s ease;
}

body.sidebar-collapse #main-content {
    margin-left: 64px;
}

/* Header adjustment */
.header-white-bg {
    margin-left: 256px;
    transition: margin-left 0.3s ease;
}

body.sidebar-collapse .header-white-bg {
    margin-left: 64px;
}

/* COLLAPSED STATE - Hide text, keep icons */
body.sidebar-collapse .sidebar-scroll span,
body.sidebar-collapse .side-bar-heading,
body.sidebar-collapse .sidebar-logo-text {
    opacity: 0;
    visibility: hidden;
    width: 0;
    white-space: nowrap;
}

/* Keep icons visible when collapsed */
body.sidebar-collapse .sidebar-scroll svg,
body.sidebar-collapse .side-bar svg {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Center icons when collapsed */
body.sidebar-collapse .sidebar-scroll a {
    justify-content: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Hide arrows & submenus when collapsed */
body.sidebar-collapse .chiled,
body.sidebar-collapse .fa-angle-down,
body.sidebar-collapse .fa-chevron-down {
    display: none !important;
}

/* Sidebar brand centered when collapsed */
.sidebar-brand {
    height: 56px;
    min-height: 56px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
    padding: 0 14px;
    background-color: #F7F7F7;
    border-bottom: 1px solid rgba(255,255,255,0.25);
    overflow: hidden;
    transition: justify-content 0.3s ease;
}

body.sidebar-collapse .sidebar-brand {
    justify-content: center;
}

/* Logo fixed size */
.sidebar-brand img,
.sidebar-logo-icon {
    width: 28px !important;
    height: 28px !important;
    max-width: 28px !important;
    max-height: 28px !important;
    object-fit: contain;
    flex-shrink: 0;
}

/* Sidebar scroll area */
.sidebar-scroll {
    height: calc(100vh - 56px);
    overflow-y: auto;
    overflow-x: hidden;
}

.app-footer-fixed {
    position: fixed;
    bottom: 0;
    left: 256px;
    width: calc(100% - 256px);
    height: 36px;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
    transition: left 0.3s ease, width 0.3s ease;
    z-index: 999;
}

body.sidebar-collapse .app-footer-fixed {
    left: 64px;
    width: calc(100% - 64px);
}

    .sidebar-edge-toggle svg {
        width: 16px;
        height: 16px;
       transition: transform 0.25s ease, left 0.25s ease;
    }

    .sidebar-edge-toggle:hover {
        box-shadow: 0 8px 22px rgba(0,0,0,0.25);
/*         transform: translateX(-20%) scale(1.05); */
    }


/* Collapsed width */
body.sidebar-collapse .side-bar {
    width: 64px !important;
}

body.sidebar-collapse .sidebar-scroll span,
body.sidebar-collapse .side-bar-heading {
    opacity: 0;
    visibility: hidden;
    white-space: nowrap;
}

/* body.sidebar-collapse .sidebar-scroll svg { */
/*     opacity: 1 !important; */
/* } */


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

.sidebar-scroll {
    height: calc(100vh - 56px); /* subtract brand height */
    overflow-y: auto;
    overflow-x: hidden;
}


/* Default (sidebar open) */
#main-content {
/*     margin-left: 256px; */

     height: 100vh;
      overflow-y: auto;
      overflow-x: hidden;
}

/* #main-content { */
/*     transform: translateX(0); */
/*     transition: transform 0.3s ease; */
/* } */

#main-content {
    margin-left: 256px;
    transition: margin-left 0.3s ease;
}

body.sidebar-collapse #main-content {
    margin-left: 64px;
}


/* Collapsed sidebar */
body.sidebar-collapse #main-content {
/*     margin-left: 64px; */
}


/* ================= SIDEBAR BRAND — COMPACT (FINAL) ================= */
.sidebar-brand {
    height: 56px;              /* REDUCED HEIGHT */
    min-height: 56px;
    display: flex;
    align-items: center;       /* vertical center */
    justify-content: center;
    gap: 8px;
    padding: 0 14px;
    background-color: #F7F7F7;
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
    width: 31px;
    height: 30px;
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
    width: 31px;
    height: 30px;
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
    /* Lock sidebar height permanently */
    .main-sidebar,
    .side-bar {
        height: 100vh;
        min-height: 100vh;
        overflow: hidden;
    }
    </style>

<style>


.header-white-bg {
    background: #ffffff !important;
    position: relative;
    margin-left: 0 !important;  /* Remove margin */
    width: 100%;  /* Full width */
    transition: none !important;
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
    border: none !important;          /*removed box */
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
    /* Disable animations during preload */
    .preload .side-bar,
    .preload .sidebar-edge-toggle,
    .preload #main-content,
    .preload .header-white-bg {
        transition: none !important;
    }


/* ===== FIX TOGGLE LAG (PRELOAD LOCK) ===== */
.preload .sidebar-edge-toggle {
    position: fixed !important;
    top: 67px !important;

    /* DEFAULT = sidebar open */
    left: 256px !important;

    transform: translateX(-50%) !important;
    opacity: 1 !important;
    visibility: visible !important;

    transition: none !important;
}

html.sidebar-collapse.preload .sidebar-edge-toggle {
    left: 64px !important;
}

    </style>


<style>
    /* ===== SIDEBAR BRAND ===== */
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        padding-top:8px;
        height: 64px;
        overflow: hidden;
        white-space: nowrap;
    }

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

<style>
    /* ================= FIX: Notification Template tab style ================= */
    /* Target ONLY Notification Template item */
    .side-bar a[href*="notification"],
    .side-bar li:has(a[href*="notification"]) > a {
        background: transparent !important;
        border-radius: 0 !important;
        padding-left: inherit !important;
        padding-right: inherit !important;
    }

    /* Make text style SAME as other tabs */
    .side-bar a[href*="notification"] span{
        font-weight: 500 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        font-size: 12px !important;
    }

    /* Remove pill / badge look if any */
    .side-bar a[href*="notification"] .badge,
    .side-bar a[href*="notification"] .label {
        display: none !important;
    }


.form-shift{
margin-left: 80px;
}
.form-shift1{
margin-left: 40px;
}
.left-shift{
margin-left:50px;
}
    </style>


<style>

    /* ================= MODERN INPUT DESIGN (CSS ONLY) ================= */

    /* Wrapper spacing */
    .form-group {
        position: relative;
    }
    /* Base input style */
    .form-control {
        height: 48px;
        padding-left: 19px;               /* space for icon */
        padding-right: 14px;
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        background-color: #ffffff;
        box-shadow: none;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    /* Textarea support */
    textarea.form-control {
        height: auto;
        padding-top: 12px;
    }

    /* Focus state */
    .form-control:focus {
        border-color: #6366f1;            /* soft indigo */
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }

    /* Label style */
    .form-group label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }

   .has-error .form-control {
        border-color: #ef4444;
    }

    /* Required star */
    .form-group label span,
    .form-group label sup {
        color: #ef4444;
    }

    /* ================= LEFT ICON SUPPORT ================= */

    /* If icon exists before input */
    .form-group i,
    .form-group svg {
/*         position: absolute; */
        left: 5px;
        top: 16px;
        width: 18px;
        height: 18px;
        color: #9ca3af;
        pointer-events: none;
    }

    /* When input is focused → icon color */
    .form-control:focus ~ i,
    .form-control:focus ~ svg {
        color: #6366f1;
    }

    /* ================= SELECT2 MATCH ================= */

    .select2-container--default .select2-selection--single {
        height: 48px;
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        padding-left: 38px;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: #6366f1;
    }


    .select2-selection__arrow {
        top: 10px !important;
    }

    /* ================= ERROR STATE ================= */


    .has-error .help-block {
        color: #ef4444;
        font-size: 12px;
    }

  .whitish{
    background-color: #ffffff
  }

    </style>


<style>
    /* ===== TOP METRICS BAR (Image 1 Style) ===== */

    .dashboard-metrics-bar {
        display: grid;
        grid-template-columns: repeat(6, 1fr); /* 6 in one line */
        gap: 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
/*         background: color/grey/200; */
    }

.text-info{
 color: grey !important;
}
.hover-q{
font-size: 13px !important;
}

    /* Remove card look */
    .dashboard-metrics-bar > div {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        background: transparent !important;
/*         padding: 14px 20px; */
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Add vertical divider */
    .dashboard-metrics-bar > div:not(:last-child) {
        border-right: 1px solid #f1f5f9;
    }

    /* Icon smaller & subtle */
    .dashboard-metrics-bar svg {
        width: 20px;
        height: 22px;
        color: #A8B0C5;
    }

    /* Title text */
    .dashboard-metrics-bar p:first-child {
        font-size: 13px;
        font-weight: 500;
        color: #333333;
        margin-bottom: 2px;
    }

    /* Value text */
    .dashboard-metrics-bar p:last-child {
        font-size: 20px;
        font-weight: 600;
        color: #333333;
    }

/* ================= TOP METRICS RESPONSIVE FIX ================= */

.dashboard-metrics-bar {
    display: grid;
    gap: 1rem;

    /* Desktop: 6 in one row */
    grid-template-columns: repeat(6, minmax(0, 1fr));
}

/* Large tablet */
@media (max-width: 1400px) {
    .dashboard-metrics-bar {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* Tablet */
@media (max-width: 1100px) {
    .dashboard-metrics-bar {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Small tablet */
@media (max-width: 768px) {
    .dashboard-metrics-bar {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 480px) {
    .dashboard-metrics-bar {
        grid-template-columns: 1fr;
    }
}

}

    </style>

</html>












