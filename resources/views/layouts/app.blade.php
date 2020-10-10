<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.partials.htmlheader')
<body class="mod-bg-1 mod-nav-link nav-function-fixed">
    
    <div class="page-wrapper">
        <div class="page-inner">
            <!-- BEGIN Left Aside -->
            @include('layouts.partials.nav')
            <!-- END Left Aside -->
            <div class="page-content-wrapper">
                <!-- BEGIN Page Header -->
                @include('layouts.partials.header')
                <!-- END Page Header -->
                <!-- BEGIN Page Content -->
                <!-- the #js-page-content id is needed for some plugins to initialize -->
                <main id="js-page-content" role="main" class="page-content">
            
                    @yield('content')
                    
                </main>
                <!-- this overlay is activated only when mobile menu is triggered -->
                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
               
                <!-- BEGIN Shortcuts -->
                <div class="modal fade modal-backdrop-transparent" id="modal-shortcut" tabindex="-1" role="dialog" aria-labelledby="modal-shortcut" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-top modal-transparent" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <ul class="app-list w-auto h-auto p-0 text-left">
                                    <li>
                                        <a href="intel_introduction.html" class="app-list-item text-white border-0 m-0">
                                            <div class="icon-stack">
                                                <i class="base base-7 icon-stack-3x opacity-100 color-primary-500 "></i>
                                                <i class="base base-7 icon-stack-2x opacity-100 color-primary-300 "></i>
                                                <i class="fal fa-home icon-stack-1x opacity-100 color-white"></i>
                                            </div>
                                            <span class="app-list-name">
                                                Home
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page_inbox_general.html" class="app-list-item text-white border-0 m-0">
                                            <div class="icon-stack">
                                                <i class="base base-7 icon-stack-3x opacity-100 color-success-500 "></i>
                                                <i class="base base-7 icon-stack-2x opacity-100 color-success-300 "></i>
                                                <i class="ni ni-envelope icon-stack-1x text-white"></i>
                                            </div>
                                            <span class="app-list-name">
                                                Inbox
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="intel_introduction.html" class="app-list-item text-white border-0 m-0">
                                            <div class="icon-stack">
                                                <i class="base base-7 icon-stack-2x opacity-100 color-primary-300 "></i>
                                                <i class="fal fa-plus icon-stack-1x opacity-100 color-white"></i>
                                            </div>
                                            <span class="app-list-name">
                                                Add More
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Shortcuts -->
                
            </div>
        </div>
    </div>

    <nav class="shortcut-menu d-none d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <a href="{{ route('send_sms') }}" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Send SMS">
            <i class="fal fa-envelope"></i>
        </a>
        <a href="{{ route('members.index') }}" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Members">
            <i class="fal fa-users"></i>
        </a>
        <a href="{{ route('members.create') }}" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Add Member">
            <i class="fal fa-user"></i>
        </a>
        <a href="{{ route('templates.index') }}" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="SMS Templates">
            <i class="fal fa-file"></i>
        </a>
        <a href="{{ ('templates.index') }}" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
            <i class="fal fa-expand"></i>
        </a>
    </nav>

    @include('layouts.partials.scripts')
</body>
</html>
