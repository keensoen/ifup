<script src="{{ URL::to('js/vendors.bundle.js') }}"></script>
<script src="{{ URL::to('js/app.bundle.js') }}"></script>
<script type="text/javascript">
    /* Activate smart panels */
    $('#js-page-content').smartPanel();
</script>

@stack('js')