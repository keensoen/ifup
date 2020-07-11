<ul class="nav-link">
    <li class="{{ Request::is('*/sent_sms') ? 'active': '' }}">
        <a href="{{ route('sent_sms')}}" title="Sent SMS" data-filter-tags="sms messages sent">
            <span class="nav-link-text" data-i18n="nav.sms_messages_sent">Sent SMS</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/failed_sms') ? 'active' : '' }}">
        <a href="{{ route('failed_sms') }}" title="Failed SMS" data-filter-tags="sms messages failed">
            <span class="nav-link-text" data-i18n="nav.sms_messages_failed">Failed SMS</span>
        </a>
    </li>
    <div class="divider mb-3"></div>
    <li class="{{ Request::is('*/external') ? 'active' : '' }}">
        <a href="{{ route('external_sms') }}" title="External SMS" data-filter-tags="sms messages external">
            <span class="nav-link-text" data-i18n="nav.sms_messages_external">External SMS</span>
        </a>
    </li>
</ul>