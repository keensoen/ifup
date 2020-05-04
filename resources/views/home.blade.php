@extends('layouts.app')

@section('page_title') Dashboard @stop
@section('content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
    <li class="breadcrumb-item">@yield('page_title')</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="row">
    <div class="panel-tag">
        <div class="row">
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalUnits }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">SMS units</small>
                        </h3>
                    </div>
                    <i class="fal fa-envelope position-absolute pos-right pos-bottom opacity-25 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalMembers }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Members</small>
                        </h3>
                    </div>
                    <i class="fal fa-users position-absolute pos-right pos-bottom opacity-25  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalBirthday }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Birthday</small>
                        </h3>
                    </div>
                    <i class="fal fa-gift position-absolute pos-right pos-bottom opacity-25 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalPresent }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Present</small>
                        </h3>
                    </div>
                    <i class="fal fa-calendar-plus position-absolute pos-right pos-bottom opacity-25 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalAbsent }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Absentism</small>
                        </h3>
                    </div>
                    <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-25 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalPrayers }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Prayers</small>
                        </h3>
                    </div>
                    <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-25  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalComments }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">Feedback</small>
                        </h3>
                    </div>
                    <i class="fal fa-comments position-absolute pos-right pos-bottom opacity-25 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xl-3">
                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $totalUsers }}
                            <small class="m-0 l-h-n" style="font-weight:bold;font-size:20px;">System User</small>
                        </h3>
                    </div>
                    <i class="fal fa-user-circle position-absolute pos-right pos-bottom opacity-25 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div id="panel-2" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
            <div class="panel-hdr">
                <h2>
                    Feedback Words Analysis <span class="fw-300"><i>Monthly</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content poisition-relative">
                    <div id="feedback" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="panel-3" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
            <div class="panel-hdr">
                <h2>
                    Prayer Request Words Analysis <span class="fw-300"><i>Monthly</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content poisition-relative">
                    <div id="prayers" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div id="panel-2" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
            <div class="panel-hdr">
                <h2>
                    Absentism <span class="fw-300"><i>(Today and the past 6 days)</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content poisition-relative">
                    <table id="dt-basic-absent" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Address') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absents as $i => $member)
                                <tr>
                                    <td width="3">{{ ++$i }}</td>
                                    <td>{{ $member['fullname'] }}</td>
                                    <td>{{ $member['tel'] }}</td>
                                    <td>
                                        @if($member['address'])
                                            {{ $member['address'] }}
                                        @else
                                            {{ __('Not Set') }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">No Record Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div id="panel-3" class="panel panel-locked" data-panel-sortable data-panel-collapsed data-panel-close>
            <div class="panel-hdr">
                <h2>
                    Upcoming Birthdays <span class="fw-300"><i>Monthly</i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content poisition-relative">
                    <table id="dt-basic-birthday" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Birthday') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingBirthday as $i => $member)
                                <tr>
                                    <td width="3">{{ ++$i }}</td>
                                    <td>{{ $member['fullname'] }}</td>
                                    <td>{{ $member['tel'] }}</td>
                                    <td>{{ date('jS F', strtotime($member['birthday'])) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">No Record Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" media="screen, print" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
<link rel="stylesheet" href="{{ URL::to('https://cdn.anychart.com/releases/v8.7.1/css/anychart-ui.min.css') }}" />
@endpush

@push('js')
<script src="{{ URL::to('js/anyChart/anychart-core.min.js') }}"></script>
<script src="{{ URL::to('js/anyChart/anychart-tag-cloud.min.js') }}"></script>
<script>
    anychart.onDocumentReady(function() {
        var prayerData = "{{ $prayerData }}"
        var prayerChart = anychart.tagCloud();

        prayerChart.data(prayerData, {
            mode: "byWord",
            maxItems: 150,
            ignoreItems: ['a', "the",'father', 'my', "and","he","or", "of","in","thy", 'wife', 'husband', 'okechukwu', 'daniel', 'sesughter', 'chidinma', 'gladys', 'to', 'me', 'will', 'you', 'he', 'him', 'for', 'i', 'see', 'let','father', 'please', 'your', 'us', 'with', 'her', 'she', 'said', 'at', 'any', 'call', 'by', 'have', 'has', 'their', 'ieren', 'this', 'all', 'lord', 'as']
        });
        
        prayerChart.angles([0]);

        prayerChart.container('prayers');
        prayerChart.draw();
    });
</script>
<script>
    anychart.onDocumentReady(function() {
        var commentData = "{{ $commentData }}"
        var commentChart = anychart.tagCloud();

        commentChart.data(commentData, {
            mode: "byWord",
            maxItems: 150,
            ignoreItems: ["the", "and","he","or", "of","in","thy", 'self', 'yourself', 'myself']
        });

        commentChart.angles([0]);

        commentChart.container('feedback');
        commentChart.draw();
    });
</script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>
<script>
    $(document).ready(function()
    {
        $('#dt-basic-absent').dataTable(
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
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });

        $('#dt-basic-birthday').dataTable(
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
                    extend: 'print',
                    text: 'Print',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-primary btn-sm'
                }
            ]
        });

    });

</script>
@endpush
