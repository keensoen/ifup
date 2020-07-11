@extends('layouts.app')

@section('page_title') Member Contact @Stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="d-flex flex-grow-1 p-0 shadow-1">
        <!-- left slider panel : must have unique ID-->
        <div id="js-slide-left" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-left bg-primary-100 pattern-0 p-3">
            <div class="panel-tag">
                <h5>Member Related Reports</h3>
            </div>
            <div class="divider mb-5"></div>
            <div class="panel-tag">
                @include('report.member.menu')
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
                    <h5>@yield('page_title') List</h5><hr>
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
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="2">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Phone') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $i => $member)
                                <tr>
                                    <td width="2" align="center">{{ ++$i }}</td>
                                    <td>
                                        @if(empty($member->photo))
                                            @if($member->salute['short_code'] === 'Mrs.' || $member->salute['short_code'] === 'Pst. Mrs.' || $member->salute['short_code'] === 'Miss.' || $member->salute['short_code'] === 'Sis.')
                                                <img src="{{URL::to('img/avatar-f.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $member['fullname']}}">
                                            @else
                                                <img src="{{URL::to('img/avatar-m.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $member['fullname']}}">
                                            @endif
                                        @else
                                            <img src="{{URL::to($member->photo)}}" class="img rounded-circle " height="30" width="30" alt="{{ $member['fullname']}}">
                                        @endif
                                        {{ $member['fullname'] }}
                                    </td>
                                    <td>{{ $member['tel'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align:center;">No Record Found!</td>
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
    <script>
        $(function()
        {

            $('#dt-basic-example').dataTable(
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
                        extend: 'csvHtml5',
                        text: 'CSV',
                        titleAttr: 'Generate CSV',
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