<ul class="nav-link">
    <li class="{{ Request::is('*/prayers') ? 'active' : ''}}">
        <a href="{{ route('panalysis') }}" title="Prayers" data-filter-tags="reports prayers">
            <span class="nav-link-text" data-i18n="nav.reports_prayers">Prayers</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/feedback') ? 'active' : ''}}">
        <a href="{{ route('fanalysis')}}" title="Feedback" data-filter-tags="reports feedback">
            <span class="nav-link-text" data-i18n="nav.reports_feedback">Feedback</span>
        </a>
    </li>
</ul>