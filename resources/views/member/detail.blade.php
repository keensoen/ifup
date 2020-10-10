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
                                                    @if(!is_null($member['salutation_id'])) {{ $member->salute['short_code'] }}  @endif {{ $member['fullname'] }}
                                                    <small class="text-white mb-0">
                                                        @if(!is_null($member['address']))
                                                            {{ $member['address'] }}
                                                        @endif
                                                    </small>
                                                </h5>
                                                <div class="mt-4 text-white text-center demo">
                                                    <span>{{ $member->tel }}</span>&nbsp;&nbsp;<span>{{ $member->email }}</span><br />
                                                    <span>Birthday - @if(!is_null($member['birthday'])) {{ date('jS F', strtotime($member->birthday)) }} @else {{ ('Not set')}} @endif</span>
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
                                        <form method="POST", action="{{ route('members.destroy', $member['slug']) }}">
                                            {{method_field('DELETE')}}
                                            {{csrf_field()}}
                                            <button type="submit" id="deleteTrigger" class="btn btn-sm btn-outline-danger mr-2" onclick="return confirm('Are you sure to delete');"><i class="fal fa-times"></i> Archive Record</button>
                                        </form>
                                        <a href='{{ route('members.edit', $member['slug']) }}' class='btn btn-sm btn-outline-primary mr-2' title='Edit'>
                                            <i class="fal fa-edit"></i> Edit
                                        </a>
                                        <a href='javascript:void(0);' data-toggle="modal" data-target=".default-example-modal-right-sm" class='btn btn-sm btn-outline-primary mr-2' title='Feedback'>
                                            <i class="fal fa-comments"></i> Feedback
                                        </a>
                                        <div class="modal fade default-example-modal-right-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-right modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h4">ADD VISIT FEEDBACK</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card mb-g">
                                                            <div class="card-body p-3">
                                                                <div class="row fs-b fw-300">
                                                                    <form method="GET" action="{{ route('visit_feedback') }}" autocomplete="off">
                                                                        @csrf
                                                                        <input type="hidden" name="member_id" id="member_id" value="{{ $member['id'] }}">
                                                                        <div class="form-group">
                                                                            <textarea name="comment" id="comment" cols="30" rows="10" class="form-control js-summernote @error('comment') is-invalid @enderror" placeholder="Visit Feedback"></textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Save Feedback</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <table id="dependent" class="table table-bordered table-hover table-striped">
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
                                                        <td>@if(!is_null($member['birthday'])) {{ date('jS M', strtotime($member->birthday)) }} @else {{ ('Not set')}} @endif</td>
                                                        <td>@if(!is_null($member['service_interest_id'])) {{ $member->serviceInterest['short_code'] }} @else {{ ('Not set')}} @endif</td>
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
                                        <table id="prayers" class="table table-bordered table-hover table-striped">
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
                                        <table id="comment" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>s/N</th>
                                                <th>Comment</th>
                                                <th>Created At</th>
                                            </thead>
                                            <tbody>
                                                @forelse($member->comments as $i => $item)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{!! $item['comment'] !!}</td>
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
                            <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-2">
                                <!-- dependents -->
                                <div class="card mb-g">
                                    <div class="card-header">
                                        <h4>Visit Report</h4>
                                    </div>
                                    <div class="card-body pb-0 px-4">
                                        <table id="feedback" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>s/N</th>
                                                <th>Visit Feedback</th>
                                                <th width="12%">Created At</th>
                                            </thead>
                                            <tbody>
                                                @forelse($member->member_report as $i => $item)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $item['comment'] }}</td>
                                                        <td>{{ date('jS M, Y', strtotime($item->created_at)) }}</td>
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
                                <!-- dependent- end -->
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
                                                <td>@if(!is_null($member['service_interest_id'])) {{ $member->serviceInterest['name'] }} @else {{ ('Not set')}} @endif</td>
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
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/formplugins/summernote/summernote.css') }}">
@endpush

@push('js')
<script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::to('js/datagrid/datatables/datatables.export.js') }}"></script>
<script src="{{ URL::to('js/formplugins/summernote/summernote.js') }}"></script>
<script>
    $(document).ready(function()
    {
        // initialize datatable
        $('#dependent').dataTable(
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
        $('#feedback').dataTable(
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
        $('#prayers').dataTable(
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
        $('#comment').dataTable(
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

        $('.js-summernote').summernote(
        {
            height: 200,
            tabsize: 2,
            placeholder: "Type here...",
            dialogsFade: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks:
            {
                //restore from localStorage
                onInit: function(e)
                {
                    $('.js-summernote').summernote("code", localStorage.getItem("summernoteData"));
                },
                onChange: function(contents, $editable)
                {
                    clearInterval(interval);
                    timer();
                }
            }
        });
    });

</script>
@endpush