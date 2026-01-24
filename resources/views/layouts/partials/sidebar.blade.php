<!-- Left side column. contains the logo and sidebar -->
<!--<aside class="side-bar tw-relative tw-hidden tw-h-full tw-bg-white tw-w-64 xl:tw-w-64 lg:tw-flex lg:tw-flex-col tw-shrink-0">-->

<aside
  class="main-sidebar side-bar
         tw-fixed tw-top-0 tw-left-0
         tw-h-screen tw-w-64
         tw-bg-white
         lg:tw-flex lg:tw-flex-col
         tw-z-40
         tw-shrink-0
         tw-overflow-hidden">


    <!--  Business Header -->


        <a href="{{ route('home') }}"
                   class="sidebar-brand">


                    <!--
                     <div class="tw-flex-shrink-0">
                                            <svg class="tw-w-8 tw-h-8 tw-text-white" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                            </svg>
                                        </div>

                    -->


                    <p class="tw-text-lg tw-font-medium tw-text-white tw-text-center side-bar-heading tw-ml-3 tw-truncate">
                        {{ Session::get('business.name') }}
                        <span class="tw-inline-block tw-w-3 tw-h-3 tw-bg-green-400 tw-rounded-full tw-ml-2"></span>
                    </p>
                </a>






    <!--  Scrollable Menu -->
    <div class="tw-flex-1 tw-overflow-y-auto tw-overflow-x-hidden sidebar-scroll">
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}
    </div>
</aside>





