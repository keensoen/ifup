@extends('layouts.app')

@section('page_title') Failed SMS @Stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Management</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="d-flex flex-grow-1 p-0 shadow-1">
        <!-- left slider panel : must have unique ID-->
        <div id="js-slide-left" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-left bg-primary-100 pattern-0 p-3">
            <div class="panel-tag">
                <h5>SMS Report</h3>
            </div>
            <div class="panel-tag">
                @include('general.smsMenu')
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
                            Click here for more <i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-tag">
                    <h5>Failed SMS List</h5><hr />
                    <form method="get" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="input-group input-group-multi-transition">
                                <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                <input type="text" readonly="" class="form-control" aria-label="" placeholder="">
                                <input type="text" readonly="" class="form-control" aria-label="Person name" placeholder="">
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
                    
                    <table id="dt-basic-failed-sms" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('SMS Content') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $i => $item)
                                <tr>
                                    <td width="3">{{ ++$i }}</td>
                                    <td>{{ $item->member['fullname'] }}</td>
                                    <td>{{ $item->member['tel'] }}</td>
                                    <td>
                                        @if(!is_null($item['sms_template_id']) || !empty($item['sms_template_id']))
                                            {{ $item->smsTemplate['message_temp'] }} 
                                            <br/> 
                                            <span class="badge badge-danger">{{ date('d-m-Y h:m:s', strtotime($item['created_at'])) }}</span>
                                        @else
                                            {{ $item['content'] }} 
                                            <br/>
                                            <span class="badge badge-danger">{{ date('d-m-Y h:i:s', strtotime($item['created_at'])) }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;"> 
                                        @if($item['status'] == '1')
                                            <span class="badge badge-success"> Sent </span>
                                        @else
                                            <span class="badge badge-danger"> Failed </span>
                                            <a href="{{ route('resend_sms', ['member' => $item->member->id, 'date' => ($item->created_at)->format('Y-m-d')])}}" class="btn btn-info btn-xs btn-icon rounded-circle">
                                                <i class="fal fa-exchange"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;">No Record Found!</td>
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

    <script src="{{ URL::to('js/datepicker/moment.min.js') }}"></script>
    <script src="{{ URL::to('js/datepicker/daterangepicker.js') }}"></script>
    <script>
        $(function()
        {

            $('#dt-basic-failed-sms').dataTable(
            {
                responsive: true
            });
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