@extends('layouts.app')

@section('page_title') SMS Template Detail @Stop

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
                <h5>@yield('page_title')</h3>
            </div>
            <hr size="5" style="color:white;height:15px;border:2;" class="mb-5">
            {!! Form::open(['method' => 'POST', 'route' => ['templates.store'], 'novalidate' => '']) !!}
                @csrf
                <div class="form-group">
                    <label lass="form-label" for="month">Select Month & Year</label>
                    <div class="input-group">
                        <input type="text" name="month" id="month" class="form-control" placeholder="Month & Year">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::textarea('message_temp', null, ['class'=> 'form-control', 'id'=>'message', 'rows' => 7,'maxLength'=>125, 'onkeyup'=>'countChars(this)', 'placeholder' => 'Birthday Wish']) !!}
                    <p id="counter" class="form-control"></p>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary btn-md" >
                        <i class="fal fa-plus"></i> Add
                    </button>
                </div>
            </form>
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
                            Click here for more<i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-tag">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td width="150"><strong>{{ __('Month & Year') }}</strong></td>
                                <td>
                                    {{ $template['month'] }} {{ $template['year'] }}
                                    <a href="{{ route('templates.index') }}" class="btn btn-primary btn-md text-right float-right" ><i class="fal fa-backward"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td width="150"><strong>{{ __('Message') }}</strong></td>
                                <td>{{ $template['message_temp'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content-panel">
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th width="3">{{ __('s/N') }}</th>
                                <th>{{ __('Fullname') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Birthday') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($template->smsLog as $i => $item)
                                <tr>
                                    <td width="3">{{ ++$i }}</td>
                                    <td>{{ $item->member['fullname'] }}</td>
                                    <td>{{ $item->member['tel'] }}</td>
                                    <td>{{ date('jS M', strtotime($item->member->birthday)) }}</td>
                                    <td style="text-align:center;"> 
                                        @if($item['status'] == '1')
                                            <span class="badge badge-success"> Sent </span>
                                        @else
                                            <span class="badge badge-danger"> Failed </span>
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
@endpush

@push('js')
    <script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(function()
        {

            $('#dt-basic-example').dataTable(
            {
                responsive: true
            });
        });

    </script>
@endpush