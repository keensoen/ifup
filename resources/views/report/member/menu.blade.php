<ul class="nav-link">
    <li class="{{ Request::is('*/birthdays') ? 'active' : ''}}">
        <a href="{{ route('breports') }}" title="Birthday" data-filter-tags="reports birthday">
            <span class="nav-link-text" data-i18n="nav.reports_birthday">Birthdays</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/new-residents') ? 'active' : ''}}">
        <a href="{{ route('new_resident')}}" title="New Resident" data-filter-tags="reports new residents">
            <span class="nav-link-text" data-i18n="nav.reports_new_residents">New Residents</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/non-baptized') ? 'active' : ''}}">
        <a href="{{ route('nbaptized')}}" title="Organizations" data-filter-tags="reports organizations">
            <span class="nav-link-text" data-i18n="nav.reports_organizations">Not Baptized</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/serviceType') ? 'active' : ''}}">
        <a href="{{ route('service_type') }}" title="Service Types" data-filter-tags="reports service types">
            <span class="nav-link-text" data-i18n="nav.reports_service_types">Service Type</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/contacts') ? 'active' : ''}}">
        <a href="{{ route('contact')}}" title="Member Contacts" data-filter-tags="reports member contacts">
            <span class="nav-link-text" data-i18n="nav.reports_member_contacts">Member Contacts</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/like-workforce') ? 'active' : ''}}">
        <a href="{{ route('likeWorkforce') }}" title="Like Workforce" data-filter-tags="reports like workforce">
            <span class="nav-link-text" data-i18n="nav.reports_like_workforce">Like Workforce</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/like-membership') ? 'active' : ''}}">
        <a href="{{ route('likeMembership')}}" title="Like Membership" data-filter-tags="reports like membership">
            <span class="nav-link-text" data-i18n="nav.reports_like_memberships">Like Membership</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/like-visited') ? 'active' : ''}}">
        <a href="{{ route('likeVisited')}}" title="Like Visited" data-filter-tags="reports like visited">
            <span class="nav-link-text" data-i18n="nav.reports_like_visited">Like Visited</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/archived') ? 'active' : ''}}">
        <a href="{{ route('archived')}}" title="Archived Members" data-filter-tags="reports archived members">
            <span class="nav-link-text" data-i18n="nav.reports_like_visited">Archived Members</span>
        </a>
    </li>
</ul>