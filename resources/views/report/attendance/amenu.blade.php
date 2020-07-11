<ul class="nav-link">
    <li class="{{ Request::is('*/present') ? 'active' : ''}}">
        <a href="{{ route('present') }}" title="Present" data-filter-tags="reports present">
            <span class="nav-link-text" data-i18n="nav.reports_present">Members Present</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/absent') ? 'active' : ''}}">
        <a href="{{ route('absent')}}" title="Absent" data-filter-tags="reports absent">
            <span class="nav-link-text" data-i18n="nav.reports_absent">Members Absent</span>
        </a>
    </li>
</ul>