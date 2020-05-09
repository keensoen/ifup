@extends('layouts.app')

@section('page_title') Attendance @stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Management</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        <form method="get" accept-charset="utf-8">
                            <div class="form-group">
                                <div class="input-group input-group-multi-transition">
                                    <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                    <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                    <input type="text" readonly="" class="form-control" aria-label="" name="">
                                    <input type="text" readonly="" class="form-control" name="date_filter" aria-label="Date filter" id="date_filter">
                                    <div class="input-group-append">
                                        <button class="btn btn-xs btn-success col-offset-5">
                                            <i class="fal fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th width="3">s/N</th>
                                    <th>Fullname</th>
                                    <th>Location</th>
                                    <th>Clock In</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendances as $i => $item)
                                    <tr>
                                        <td style="text-align:center;">{{ ++$i }}</td>
                                        <td>
                                            {{ $item->member['fullname'] }}
                                        </td>
                                        <td>
                                            @push('js')
                                                <script type="text/javascript">
                                                    var KEY = "AIzaSyB6S7aOQ9zNQyn57BzqoCKbQKQN7gwCAlY";
                                                    var total = {{$item->count()}};
                                                    var i = 0;

                                                    var url = `https://maps.googleapis.com/maps/api/geocode/json?latlng={{ $item->latitude }},{{ $item->longitude }}&key=${KEY}`;
                                                    fetch(url)
                                                        .then(response => response.json())
                                                        .then(data => {
                                                           i++
                                                           $('#address'+i+'').append(data.results[0].formatted_address)
                                                        }
                                                    )
                                                    .catch(err => console.warn(err.message));

                                                    //console.log(res);
                                                </script>
                                            @endpush
                                            <div id="address{{$i++}}"></div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;">No Record Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ URL::to('js/datepicker/daterangepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('js')
<script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>
<script>
    $(document).ready(function()
    {
        // initialize datatable
        $('#dt-basic-example').dataTable(
        {
            responsive: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    titleAttr: 'Generate PDF',
                    className: 'btn-outline-danger btn-sm mr-1'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Generate Excel',
                    className: 'btn-outline-success btn-sm mr-1'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'Generate CSV',
                    className: 'btn-outline-primary btn-sm mr-1'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    titleAttr: 'Copy to clipboard',
                    className: 'btn-outline-primary btn-sm mr-1'
                },
                {
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });
    });

</script>

<script src="{{ URL::to('js/datepicker/moment.min.js') }}"></script>
<script src="{{ URL::to('js/datepicker/daterangepicker.js') }}"></script>
    
<script>
    $(function() {

        let dateInterval = getQueryParameter('date_filter');
        let end = moment().endOf('day');
        let start = moment().subtract(6, 'days');
        if (dateInterval) {
            dateInterval = dateInterval.split(' - ');
            start = dateInterval[0];
            end = dateInterval[1];
        }
        $('#date_filter').daterangepicker({
            "showDropdowns": true,
            "showWeekNumbers": true,
            startDate: start,
            endDate: end,
            locale: {
                format: 'YYYY-MM-DD',
                firstDay: 1,
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        });

    });

    function getQueryParameter(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
</script>

@endpush