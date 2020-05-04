@extends('layouts.app')

@section('page_title') {{ $member['fullname'] }} @stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Profile</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
                                <!-- profile summary -->
                                <div class="card mb-g bg-primary text-white rounded-top" style="opacity:0.9;">
                                    <div class="row no-gutters row-grid">
                                        <div class="col-12">
                                            <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                                @if(empty($member->photo))
                                                    @if($member->salute['short_code'] === 'Mrs.' || $member->salute['short_code'] === 'Pst. Mrs.' || $member->salute['short_code'] === 'Miss.' || $member->salute['short_code'] === 'Sis.')
                                                        <img src="{{URL::to('img/avatar-f.png')}}" class="rounded-circle shadow-2 img-thumbnail" height="120" width="120" alt="{{ $member['fullname']}}">
                                                    @else 
                                                        <img src="{{URL::to('img/avatar-m.png')}}" class="rounded-circle shadow-2 img-thumbnail" height="120" width="120" alt="{{ $member['fullname']}}">
                                                    @endif
                                                @else
                                                    <img src="{{URL::to($member->photo)}}" class="rounded-circle shadow-2 img-thumbnail" height="120" width="120" alt="{{ $member['fullname']}}">
                                                @endif
                                                <h5 class="mb-0 fw-700 text-center mt-3">
                                                    {{ $member['fullname'] }}
                                                    <small class="text-white mb-0">
                                                        @if(!is_null($member['address']))
                                                            {{ $member['address'] }}
                                                        @endif
                                                    </small>
                                                </h5>
                                                <div class="mt-4 text-white text-center demo">
                                                    <span>{{ $member->tel }}</span>&nbsp;&nbsp;<span>{{ $member->email }}</span><br />
                                                    <span>Birthday - {{ date('jS F', strtotime($member->brithday)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-3">
                                                <h5 class="mb-0 fw-700">
                                                    @if($member->has('parent'))
                                                        {{ $member->dependents($member->id)->count() }}
                                                    @else
                                                        0
                                                    @endif
                                                    <small class="text-white mb-0">Dependent</small>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-3">
                                                <h5 class="mb-0 fw-700">
                                                    @if($member->has('prayers'))
                                                        {{ $member->prayers->count() }}
                                                    @else
                                                        0
                                                    @endif
                                                    <small class="text-white mb-0">Prayer Requests</small>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-3">
                                                <h5 class="mb-0 fw-700">
                                                    @if($member->has('comments'))
                                                        {{ $member->comments->count() }}
                                                    @else
                                                        0
                                                    @endif
                                                    <small class="text-white mb-0">Comments</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- photos -->
                                <div class='d-flex mt-6 text-center'>
                                    @if(!is_null($member['deleted_at']))
                                        <form method="POST", action="{{ route('m.restore', $member['slug']) }}">
                                            {{method_field('POST')}}
                                            {{csrf_field()}}
                                            <button type="submit" id="deleteTrigger" class="btn btn-sm btn-outline-danger mr-2" onclick="return confirm('Are you sure to restore');"><i class="fal fa-exchange"></i> Restore Record</button>
                                        </form>
                                    @else
                                        <form method="POST", action="{{ route('comrades.destroy', $member['slug']) }}">
                                            {{method_field('DELETE')}}
                                            {{csrf_field()}}
                                            <button type="submit" id="deleteTrigger" class="btn btn-sm btn-outline-danger mr-2" onclick="return confirm('Are you sure to delete');"><i class="fal fa-times"></i> Archive Record</button>
                                        </form>
                                        <a href='{{ route('comrades.edit', $member['slug']) }}' class='btn btn-sm btn-outline-primary mr-2' title='Edit'>
                                            <i class="fal fa-edit"></i> Edit
                                        </a>
                                    @endif
                                </div>
                                <hr />
                            </div>
                            <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
                                <!-- dependents -->
                                <div class="card mb-g">
                                    <div class="card-header">
                                        <h4>Dependent List</h4>
                                    </div>
                                    <div class="card-body pb-0 px-4">
                                        <table id="dt-basic-dependent" class="table table-bordered table-hover table-striped">
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
                                    </div>
                                </div>
                                <!-- dependent- end -->
                            </div>
                            <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
                                <!-- prayer -->
                                <div class="card mb-g">
                                    <div class="card-header">
                                        <h4>Prayer Request List</h4>
                                    </div>
                                    <div class="card-body pb-0 px-4">
                                        <table id="dt-basic-prayers" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>s/N</th>
                                                <th>Prayer Point</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @forelse($member->prayers as $i => $item)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $item['prayer_point'] }}</td>
                                                        <td>
                                                            {{ date('d-m-Y h:m:s', strtotime($item['created_at'])) }}
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" style="text-align:center;">Not found!</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- prayer - end -->
                            </div>
                            <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
                                <!-- comment -->
                                <div class="card mb-g">
                                    <div class="card-header">
                                        <h4>Comment List</h4>
                                    </div>
                                    <div class="card-body pb-0 px-4">
                                        <table id="dt-basic-comment" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>s/N</th>
                                                <th>Comment</th>
                                                <th>Created At</th>
                                            </thead>
                                            <tbody>
                                                @forelse($member->comments as $i => $item)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $item['comment'] }}</td>
                                                        <td>
                                                            {{ date('d-m-Y h:m:s', strtotime($item['created_at'])) }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" style="text-align:center;">Not found!</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- comment - end -->
                            </div>
                            <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-3">
                                <div class="card mb-g">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-white bg-primary">
                                                    Member Decisions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Service Attends</td>
                                                <td>{{ $member->serviceInterest['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Workforce Interest</td>
                                                <td>
                                                    @if($member['workforce_interest'])
                                                        {{ ('Yes') }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Membership Interest</td>
                                                <td>
                                                    @if($member['membership_interest'])
                                                        {{ ('Yes') }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>First Time Visitor</td>
                                                <td>
                                                    @if($member['first_time_visitor'])
                                                        {{ ('Yes') }} on {{ date('jS F Y', strtotime($member['created_at'])) }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Returning Visitor</td>
                                                <td>
                                                    @if($member['membership_interest'])
                                                        {{ ('Yes') }} on {{ date('jS F Y', strtotime($member['created_at'])) }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>New Resident</td>
                                                <td>
                                                    @if($member['new_resident'])
                                                        {{ ('Yes') }} on {{ date('jS F Y', strtotime($member['created_at'])) }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Like Been Visited</td>
                                                <td>
                                                    @if($member['like_visited'])
                                                        {{ ('Yes') }} <br> Availability: {{ $member->availability }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Have been Saved?</td>
                                                <td>
                                                    @if($member['save_before'])
                                                        {{ ('Yes') }}
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Are you baptized?</td>
                                                <td>
                                                    @if($member['baptized'])
                                                        {{ ('Yes') }} <br> Experience: {{ $member['past_life_experience'] ? $member['past_life_experience'] : 'Not set' }} 
                                                    @else
                                                        {{ ('No') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('js')
<script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>
<script>
    $(document).ready(function()
    {
        // initialize datatable
        $('#dt-basic-dependent').dataTable(
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
        $('#dt-basic-prayer').dataTable(
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
        $('#dt-basic-comment').dataTable(
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
@endpush