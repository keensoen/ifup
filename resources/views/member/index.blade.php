@extends('layouts.app')

@section('page_title') Members @stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Management</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-tag">
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
                        @if(count($members) > 0)
                            <!-- datatable start -->
                            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>RegNumber</th>
                                        <th></th>
                                        <th style="width:200px;">Fullname</th>
                                        <th>Phone</th>
                                        <th>Birthday</th>
                                        <th>Email</th>
                                        <th>Service?</th>
                                        <th>Guidance</th>
                                        <th>Visited?</th>
                                        <th>Membership?</th>
                                        <th>Workforce-Interest?</th>
                                        <th>Saved?</th>
                                        <th>Baptized?</th>
                                        <th>Home Address</th>
                                        <th>Comment</th>
                                        <th>Prayer Request</th>
                                        <th>Dependents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $id => $member)
                                        <tr>
                                            <td>{{ $member['code'] }}</td>
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
                                            </td>
                                            <td style="width:200px;">
                                                <a href="{{ route('comrades.show', $member->slug) }}">{{ $member['fullname'] }}</a>
                                            </td>
                                            <td>{{ $member['tel'] }}</td>
                                            <td>
                                                @if(!is_null($member['birthday']))
                                                    {{ date('jS M', strtotime($member->birthday)) }}
                                                @else
                                                    {{ ('Not Set') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!is_null($member['email']) || !empty($member['email']))
                                                    {{ $member['email'] }}
                                                @else
                                                    {{ ('None') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!is_null($member['service_interest_id']))
                                                    {{ $member->serviceInterest['short_code'] }}
                                                @else
                                                    {{ ('Not Set') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @if(!is_null($member['member_link']) || !empty($member['member_link']))
                                                    {{ $member->parent['fullname'] }}
                                                @else
                                                    {{ \Str::upper('principal') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;"> 
                                                @if($member['like_visited'] == '1')
                                                    {{ ('Yes') }}
                                                @else
                                                    {{ ('No') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @if($member['membership'] == '1')
                                                    {{ ('Yes') }}
                                                @else
                                                    {{ ('No') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @if($member['workforce_interest'] == '1')
                                                    {{ ('Yes') }}
                                                @else
                                                    {{ ('No') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @if($member['save_befored'] == '1')
                                                    {{ ('Yes') }}
                                                @else
                                                    {{ ('No') }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                @if($member['baptized'] == '1')
                                                    {{ ('Yes') }}
                                                @else
                                                    {{ ('No') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!is_null($member['address']) || !empty($member['address']))
                                                    {{ $member['address'] }}
                                                @else
                                                    {{ ('None') }}
                                                @endif
                                            </td>
                                            <td>
                                                <table class="table table-striped">
                                                    <tbody>
                                                        @forelse($member->comments as $i => $comment)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{ $comment['comment'] }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2" style="text-align:center;">Not found!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-striped">
                                                    <tbody>
                                                        @forelse($member->prayers as $i => $point)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{ $point['prayer_point'] }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2" style="text-align:center;">Not found!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <th>s/N</th>
                                                        <th>RegNumber</th>
                                                        <th>Fullname</th>
                                                        <th>Phone</th>
                                                        <th>Birthday</th>
                                                        <th>Service?</th>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($member->dependents($member->id) as $i => $item)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{ $item['code'] }}</td>
                                                                <td>
                                                                    @if(empty($item->photo))
                                                                        @if($item->salute['short_code'] === 'Mrs.' || $item->salute['short_code'] === 'Pst. Mrs.' || $item->salute['short_code'] === 'Miss.' || $item->salute['short_code'] === 'Sis.')
                                                                            <img src="{{URL::to('img/avatar-f.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                                                        @else
                                                                            <img src="{{URL::to('img/avatar-m.png')}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                                                        @endif
                                                                    @else
                                                                        <img src="items/{{$item->photo}}" class="img rounded-circle " height="30" width="30" alt="{{ $item['fullname']}}">
                                                                    @endif
                                                                    {{ $item['fullname'] }}
                                                                </td>
                                                                <td>{{ $item['tel'] }}</td>
                                                                <td>{{ date('jS M', strtotime($member->birthday)) }}</td>
                                                                <td>{{ $member->serviceInterest['short_code'] }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" style="text-align:center;">Not found!</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        @else
                            <div class="alert alet-warning text-center">
                                <span style="font-size:15px;">No record Found! 
                                    <a href="{{ route('comrades.create') }}"> click here to add</a> 
                                    <h2>OR</h2>
                                    <div class="row text-center" style="align-items:center;">
                                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group" style="align:center;margin-left:280px;">
                                                <div class="input-group input-group-multi-transition">
                                                    <input type="file" readonly="" name="file" class="form-control">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-xs btn-success">Import Member Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <h2>OR</h2>
                                    <a href="{{ route('comrades.index') }}">Return to Member Pool</a></span>
                            </div>
                        @endif
                    </div>
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