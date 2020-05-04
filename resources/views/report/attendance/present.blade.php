@extends('layouts.app')

@section('page_title') Members Presnt @Stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item active">@yield('page_title')</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="d-flex flex-grow-1 p-0 shadow-1">
        <!-- left slider panel : must have unique ID-->
        <div id="js-slide-left" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-left bg-primary-100 pattern-0 p-3">
            <div class="panel-tag">
                <h5>Attendance Reports</h3>
            </div>
            <div class="divider mb-5"></div>
            <div class="panel-tag">
                @include('report.attendance.amenu')
            </div>
        </div>
        <!-- left slider panel backdrop : activated on mobile, must be place immideately after left slider closing tag -->
        <div class="slide-backdrop" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-slide-left"></div>
        <!-- middle content area -->
        <div class="d-flex flex-column flex-grow-1 bg-white">
            <div class="p-2">
                <div class="row hidden-lg-up mb-g">
                    <div class="col-12">
                        <!-- this button is activated on mobile view and activates the left panel -->
                        <a href="javascript:void(0);" class="btn btn-primary btn-block btn-md" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-slide-left">
                            Click here for Menu <i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-tag">
                    <h5>@yield('page_title') List</h5> <hr>
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
                </div>
                <div class="content-panel">
                    <table id="dt-basic-present" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Clock In') }}</th>
                                <th>{{ __('Mark Date') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $i => $item)
                                <tr>
                                    <td width="3" align="center">{{ ++$i }}</td>
                                    <td>
                                        @if(empty($item->member->photo))
                                            @if($item->member->salute['short_code'] === 'Mrs.' || $item->member->salute['short_code'] === 'Pst. Mrs.' || $item->member->salute['short_code'] === 'Miss.' || $item->member->salute['short_code'] === 'Sis.')
                                                <img src="{{URL::to('img/avatar-f.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                            @else
                                                <img src="{{URL::to('img/avatar-m.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                            @endif
                                        @else
                                            <img src="{{URL::to($item->member->photo)}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                        @endif
                                        {{ $item->member['fullname'] }}
                                    </td>
                                    <td>{{ $item['latitude'] }} {{ $item['longitude'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['clock_in'])->format('h:i a') }}</td>
                                    <td> 
                                        {{ date('Y-m-d', strtotime($item->created_at)) }}
                                    </td>
                                    <td> 
                                        @if(!is_null($item['clock_in']) || !empty($item['clock_in']))
                                            <span class="badge badge-success">Present</span>
                                        @else
                                            <span class="badge badge-info">Absent</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center;">No Record Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ URL::to('js/datepicker/daterangepicker.css') }}">
@endpush

@push('js')
    <script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>

    <script src="{{ URL::to('js/datepicker/moment.min.js') }}"></script>
    <script src="{{ URL::to('js/datepicker/daterangepicker.js') }}"></script>
    <script>
        $(function()
        {
            
        });

        $('#dt-basic-present').dataTable(
            {
                responsive: true,
                dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        titleAttr: 'Generate Excel',
                        className: 'btn-outline-success btn-sm mr-1'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        titleAttr: 'Generate PDF',
                        className: 'btn-outline-danger btn-sm mr-1'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        titleAttr: 'Print Table',
                        className: 'btn-outline-primary btn-sm'
                    }
                ]
            });

    </script>
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