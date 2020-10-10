<aside class="page-sidebar">
    <div class="page-logo" align="center">
        <a href="{{url('index')}}" class="page-logo-link press-scale-down align-items-center position-relative">
            <img src="{{ URL::to('img/logo.png') }}" style="width:100px;height:50px;" alt="efellowUP" aria-roledescription="logo">
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="{{ URL::to('img/avatar-admin.png') }}" class="profile-image rounded-circle" alt="Profile">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                        @guest
                        {{ 'iFUP' }}
                        @else
                            {{ \Str::upper(Auth::user()->username) }}
                        @endguest
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm">
                    @if(auth()->user()->getRoleNames())
                        @foreach (auth()->user()->getRoleNames() as $role)
                            {{ \Str::ucfirst(\Str::of($role)->replace('-', ' ')) }}
                        @endforeach
                    @endif
                </span>
            </div>
            <img src="{{ URL::to('img/cover-2-lg.png') }}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li class="{{ Request::is('dashboard') ? 'active open' : ''}}">
                <a href="javascript::void(0)" title="Dashboard" data-filter-tags="dashboard">
                    <i class="fal fa-tachometer-fastest"></i>
                    <span class="nav-link-text" data-i18n="nav.dashboard">Dashboard</span>
                </a>
                <ul>
                    <li class="{{ Request::is('dashboard') ? 'active' : ''}}">
                        <a href="{{ route('home')}}" title="Dashboard" data-filter-tags="home dashboard">
                            <span class="nav-link-text" data-i18n="nav.dashboard_home">Home</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ 
                Request::is('members') || Request::is('members/*') ||
                Request::is('memberGroup') || Request::is('memberGroup/*') ||
                Request::is('comments') ||
                Request::is('heat-map') ||
                Request::is('attendances') ||
                Request::is('prayer_requests') ? 'active open': '' 
            }}">
                <a href="javascript::void(0)" title="Member" data-filter-tags="members">
                    <i class="fal fa-address-card"></i>
                    <span class="nav-link-text" data-i18n="nav.members">Members</span>
                </a>
                <ul>
                    <li class="{{ Request::is('memberGroup') || Request::is('memberGroup/*') ? 'active': ''}} ">
                        <a href="{{ route('memberGroup') }}" title="List" data-filter-tags="members member group">
                            <span class="nav-link-text" data-i18n="nav.member_member_group">Member Group</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('members') || Request::is('members/*') ? 'active': ''}} ">
                        <a href="{{ route('members.index') }}" title="List" data-filter-tags="members member">
                            <span class="nav-link-text" data-i18n="nav.member_new_member">Member Bank</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('prayer_requests') ? 'active': '' }}">
                        <a href="{{ route('prayer_request')}}" title="Prayers" data-filter-tags="members prayers">
                            <span class="nav-link-text" data-i18n="nav.members_prayers">Prayers</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('comments') ? 'active' : '' }}">
                        <a href="{{ route('comment') }}" title="Comments" data-filter-tags="members comments">
                            <span class="nav-link-text" data-i18n="nav.members_comments">Comments</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('attendances') ? 'active' : '' }}">
                        <a href="{{ route('attendance') }}" title="Attendance" data-filter-tags="members attendance">
                            <span class="nav-link-text" data-i18n="nav.members_attendance">Attendance</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('heat-map') ? 'active' : ''}}">
                        <a href="{{ route('heat.map') }}" title="Member HeatMap" data-filter-tags="member eyebird">
                            <span class="nav-link-text" data-i18n="nav.member_eyebirds">Member Location</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{
                Request::is('send_sms') || Request::is('sms-report/*') ? 'active open': '' 
            }}">
                <a href="javascript::void(0)" title="SMS Messages" data-filter-tags="sms_messages">
                    <i class="fal fa-envelope"></i>
                    <span class="nav-link-text" data-i18n="nav.sms_messages">Messaging</span>
                </a>
                <ul>
                    <li class="{{ Request::is('send_sms') ? 'active': ''}} ">
                        <a href="{{ route('send_sms') }}" title="Send SMS" data-filter-tags="sms messages send">
                            <span class="nav-link-text" data-i18n="nav.sms_messages_send">Send SMS</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('*/sent') || Request::is('*/failed') || Request::is('*/external') ? 'active': '' }}">
                        <a href="{{ route('sent_sms')}}" title="Sent SMS" data-filter-tags="sms messages sent">
                            <span class="nav-link-text" data-i18n="nav.sms_messages_sent">SMS Report</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('*/chat-room') || Request::is('*/chat-room') ? 'active': '' }}">
                        <a href="" title="Chat Room" data-filter-tags="sms chat room">
                            <span class="nav-link-text" data-i18n="nav.sms_chat_room">Chat Room</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{
                Request::is('members/*') || Request::is('analysis/*') || Request::is('attendance/*') ? 'active open' : ''}}">
                <a href="javascript::void(0)" title="Reports" data-filter-tags="reports">
                    <i class="fal fa-chart-bar"></i>
                    <span class="nav-link-text" data-i18n="nav.reports">Reports</span>
                </a>
                <ul>
                    <li class="{{ 
                        Request::is('*/birthdays') || Request::is('*/new-residents') ||
                        Request::is('*/non-baptized') || Request::is('*/serviceType') ||
                        Request::is('*/serviceType') || Request::is('*/contacts') ||
                        Request::is('*/like-workforce') || Request::is('*/like-membership') ||
                        Request::is('*/archived') || Request::is('*/like-visited') ? 'active' : ''
                     }}">
                        <a href="{{ route('breports') }}" title="Members" data-filter-tags="reports members">
                            <span class="nav-link-text" data-i18n="nav.reports_members">Members</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('*/present') || Request::is('*/absent') ? 'active' : ''}}">
                        <a href="{{ route('present')}}" title="Attendance" data-filter-tags="reports attendance">
                            <span class="nav-link-text" data-i18n="nav.reports_attendance">Attendance</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('*/prayers') || Request::is('*/feedback') ? 'active' : ''}}">
                        <a href="{{ route('panalysis')}}" title="Analysis" data-filter-tags="reports analysis">
                            <span class="nav-link-text" data-i18n="nav.reports_analysis">Analysis & Forcast</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{
                Request::is('miscellaneous') || Request::is('prayer-room/*') ? 'active open' : ''}}">
                <a href="javascript::void(0)" title="Miscellaneous" data-filter-tags="miscellaneous">
                    <i class="fal fa-globe"></i>
                    <span class="nav-link-text" data-i18n="nav.miscellaneous">Miscellaneous</span>
                </a>
                <ul>
                    <li class="{{ Request::is('') ? 'active' : ''}}">
                        <a href="" title="Push Notification" data-filter-tags="miscellaneous push notification">
                            <span class="nav-link-text" data-i18n="nav.miscellaneous_push_notification">Push Notification</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('*/prayer-room') || Request::is('*/prayer-room') ? 'active' : ''}}">
                        <a href="{{ route('prayer_room') }}" title="Prayer Room" data-filter-tags="miscellaneous prayer room">
                            <span class="nav-link-text" data-i18n="nav.miscellaneous_prayer_room">Prayer Room</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('') ? 'active' : ''}}">
                        <a href="" title="Organizations" data-filter-tags="miscellaneous organizations">
                            <span class="nav-link-text" data-i18n="nav.system_settings_organizations">Not Baptized</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{
                Request::is('users') || Request::is('users/*') ||
                Request::is('salutations') || Request::is('salutations/*') ||
                Request::is('organizations') || Request::is('organizations/*') ||
                Request::is('gateways') || Request::is('gateways/*') ||
                Request::is('templates') || Request::is('templates/*') ||
                Request::is('service_types') || Request::is('service_types/*') ? 'active open' : ''}}">
                <a href="javascript::void(0)" title="System Settings" data-filter-tags="system settings">
                    <i class="fal fa-cog"></i>
                    <span class="nav-link-text" data-i18n="nav.system_settings">System Settings</span>
                </a>
                <ul>
                    <li class="{{ Request::is('users') || Request::is('users/*') ? 'active' : ''}}">
                    <a href="{{ route('user') }}" title="Users" data-filter-tags="system settings users">
                            <span class="nav-link-text" data-i18n="nav.system_settings_users">Users</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('salutations') || Request::is('salutations/*') ? 'active' : ''}}">
                        <a href="{{ route('salutes')}}" title="Salutations" data-filter-tags="system settings salutations">
                            <span class="nav-link-text" data-i18n="nav.system_settings_salutations">Salutations</span>
                        </a>
                    </li>
                    @role('super-admin')
                    <li class="{{ Request::is('organizations') || Request::is('organizations/*') ? 'active' : ''}}">
                        <a href="{{ route('organization')}}" title="Organizations" data-filter-tags="system settings organizations">
                            <span class="nav-link-text" data-i18n="nav.system_settings_organizations">Organizations</span>
                        </a>
                    </li>
                    @endrole
                    <li class="{{ Request::is('service_types') || Request::is('service_types/*') ? 'active' : ''}}">
                        <a href="{{ route('servicetype') }}" title="Service Types" data-filter-tags="system settings sservice types">
                            <span class="nav-link-text" data-i18n="nav.system_settings_service_types">Service Types</span>
                        </a>
                    </li>
                    @role('super-admin')
                    <li class="{{ Request::is('gateways') || Request::is('gateways/*') ? 'active' : ''}}">
                        <a href="{{ route('gateway')}}" title="SMS Gateways" data-filter-tags="system settings sms gateways">
                            <span class="nav-link-text" data-i18n="nav.system_settings_sms_gateways">SMS Gateways</span>
                        </a>
                    </li>
                    @endrole
                    <li class="{{ Request::is('templates') || Request::is('templates/*') ? 'active' : ''}}">
                        <a href="{{ route('templates.index')}}" title="SMS Templates" data-filter-tags="system settings sms templates">
                            <span class="nav-link-text" data-i18n="nav.system_settings_sms_templates">SMS Templates</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                    <i class="fal fa-comments"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                    <i class="fal fa-life-ring"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                    <i class="fal fa-phone"></i>
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER -->
</aside>