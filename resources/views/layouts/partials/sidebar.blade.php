<!-- Left side column. contains the logo and sidebar -->
<!--<aside class="side-bar tw-relative tw-hidden tw-h-full tw-bg-white tw-w-64 xl:tw-w-64 lg:tw-flex lg:tw-flex-col tw-shrink-0">-->


    <!--  Business Header -->

         <!--
         <a href="{{ route('home') }}"
                            class="sidebar-brand">

                             <p class="tw-text-lg tw-font-medium tw-text-white tw-text-center side-bar-heading tw-ml-3 tw-truncate">
                                 {{ Session::get('business.name') }}
                                 <span class="tw-inline-block tw-w-3 tw-h-3 tw-bg-green-400 tw-rounded-full tw-ml-2"></span>
                             </p>
                         </a>
         -->

<aside class="main-sidebar side-bar tw-fixed tw-top-0 tw-left-0 tw-h-screen tw-w-64 tw-bg-white lg:tw-flex lg:tw-flex-col tw-z-40">

     <a href="{{ route('home') }}" class="sidebar-brand">

         {{-- ICON (always exists) --}}
         <img
             src="{{ asset('img/erp.jpg') }}"
             class="sidebar-logo-icon"
             width="28"
             height="28"
             alt="Logo"
         />


         {{-- FULL LOGO / NAME --}}
         <span class="sidebar-logo-text">
             {{ Session::get('business.name') }}
             <span class="status-dot"></span>
         </span>

     </a>


    <!--  Scrollable Menu -->
    <div class="tw-flex-1 tw-overflow-y-auto tw-overflow-x-hidden sidebar-scroll">
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}


                <div class="sidebar-user-full" id="sidebarUserCard">

                    <div class="user-card">
                        <div class="user-header">
                            <div class="avatar">A</div>
                            <div>
                                <div class="user-name">abc</div>
                                <div class="user-role">Admin</div>
                            </div>
                        </div>

                        <hr>

                        <a href="#">Profile</a>
                        <a href="#">User Management</a>
                        <a href="#">Subscription Package</a>
                        <a href="#">Settings</a>

                        <hr>

                        <a href="{{ route('logout') }}" class="user-link logout-link">
                                        <i class="far fa-sign-out"></i>
                                        Log out
                                    </a>
                    </div>
                </div>

</div>

<!-- BOTTOM USER ROW -->
    <div class="sidebar-user-row" id="sidebarUserToggle">

        <div class="avatar">A</div>
        <div class="user-row-text">
            <div class="user-name">abc</div>
            <div class="user-role">Admin</div>
        </div>
        <i class="fas fa-chevron-up"></i>
    </div>


</aside>


<style>


.side-bar {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.sidebar-scroll {
    flex: 1;
    overflow-y: auto;
}

.sidebar-user-row {
    margin-top: auto;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* COLLAPSED STATE */
body.sidebar-collapse .sidebar-user-row {
    display: flex !important;
    justify-content: center;
}

body.sidebar-collapse .sidebar-user-row .user-row-text,
body.sidebar-collapse .sidebar-user-row i {
    display: none;
}



    /* ================= DEFAULT (SIDEBAR OPEN) ================= */

    .sidebar-user-full {
        display: block;
            display: none;


    }

    .sidebar-user-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
    }

    .sidebar-user-mini {
        display: none;
    }


    /* ================= COLLAPSED STATE ================= */
    body.sidebar-collapse .sidebar-user-full {
        display: none !important;
    }


    body.sidebar-collapse .sidebar-user-mini {
        display: flex !important;
        justify-content: center;
        padding: 16px 0;
    }

/* ================= USER DROPDOWN BEHAVIOR ================= */

/* DEFAULT (SIDEBAR OPEN) */
.sidebar-user-full {
    display: block;
}

.sidebar-user-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
}

/* SIDEBAR COLLAPSED */
body.sidebar-collapse .sidebar-user-full {
    display: none !important;
}

body:not(.sidebar-collapse) .sidebar-user-mini {
    display: none;
}

/* Sidebar COLLAPSED */
body.sidebar-collapse .sidebar-user-full {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
}


body.sidebar-collapse .sidebar-user-mini {
    display: flex;
    justify-content: center;
    padding: 12px 0;
}

/* Hidden by default */
.sidebar-user-full {
    display: none;
    position: absolute;
    bottom: 70px;
    left: 16px;
    width: 224px;
    z-index: 1000;
}


/* Card style */
.user-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

/* Avatar */
.avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #79b88f;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* User header */
.user-header {
    display: flex;
    gap: 12px;
    align-items: center;
}

.user-name {
    font-weight: 600;
    font-size: 15px;
}

.user-role {
    font-size: 12px;
    color: #6b7280;
}

/* Menu links */
.user-card a {
    display: block;
    padding: 10px 0;
    font-size: 14px;
    color: #374151;
    text-decoration: none;
}

.user-card a:hover {
    color: #19267a;
}


    </style>






