@extends('layouts.app')

@section('page_title') Organization @Stop

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
                <h5>Add/Modify @yield('page_title')</h3>
            </div>
            <div class="divider"></div>
                @if($flag)
                    <form novalidate="" method="POST" action="{{ route('organization.store')}}" enctype="multipart/form-data">
                @else
                    <form novalidate="" method="POST" action="{{ route('organization.update', $organization['id'])}}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <img class="rounded-circle text-right" width="120" height="100" id="blah" @if($flag) src="{{ URL::to('img/logo.png') }}" @else src="{{ URL::to($organization['logo']) }}" @endif alt="Logo">
                        <input type="file" name="logo" id="logo" class="form-control text-left" onchange="previewFile()">
                    </div>
                    <div class="form-group">
                        <input type="text" id="general_name" name="general_name" class="form-control" placeholder="General Name" @if(!$flag) value="{{$organization['general_name']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="parish" name="parish" class="form-control" placeholder="Parish" @if(!$flag) value="{{$organization['parish']}}" @endif>
                    </div>
                    <div class="form-group">
                        <input type="text" id="reg_prefix" uppercase name="reg_prefix" class="form-control" placeholder="Member Reg. Prefix" @if(!$flag) value="{{$organization['reg_prefix']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="name" name="contact_person" class="form-control" placeholder="Contact Person" @if(!$flag) value="{{$organization['contact_person']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" @if(!$flag) value="{{$organization['phone']}}" @endif>
                    </div>
                    <div class="form-group">
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email Address" @if(!$flag) value="{{$organization['email']}}" @endif>
                    </div>
                    <div class="form-group">
                        <textarea rows="3" id="address" placeholder="Address" name="address" class="form-control">@if(!$flag) {{$organization['address'] }} @endif</textarea>
                    </div>
                @if($flag)
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary btn-md" >
                            <i class="fal fa-plus"></i> Add
                        </button>
                    </div>
                @else
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('organization') }}" class="btn btn-primary btn-md">
                            <i class="fal fa-cancel"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-md" >
                            <i class="fal fa-pencil"></i> Modify
                        </button>
                    </div>
                @endif
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
                            Click here for more <i class="fal fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-tag">
                    <h5>@yield('page_title') List</h5>
                </div>
                <div class="content-panel">
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Parish') }}</th>
                                <th>{{ __('Contact Person') }}</th>
                                <th width="5" align="center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($organizations as $item)
                                <tr>
                                    <td>{{ $item['code'] }}</td>
                                    <td>
                                        @if(empty($item->logo))
                                            <img src="{{URL::to('img/logo.png')}}" class="img rounded-circle " height="40" width="40" alt="{{ $item['parish']}}">
                                        @else
                                            <img src="{{URL::to($item->logo)}}" class="img rounded-circle " height="40" width="40" alt="{{ $item['parish']}}">
                                        @endif
                                        <a href="javascript:void(0);" class="text-info fw-500" data-toggle="tooltip" title="{{ $item['address']}}">
                                            <span><strong style="font-size:14px;">{{ $item['parish'] }}</strong> <sub>{{ $item['reg_prefix'] }}</sub></span><br />
                                            <span>{{ $item['general_name'] }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <h6>{{ $item['contact_person'] }}</h6>
                                        <span>{{ $item['phone'] }}</span>
                                    </td>
                                    <td width="10" align="center">
                                        <a href="{{route('organization.edit', $item['id'])}}" class="btn btn-info btn-xs btn-icon rounded-circle">
                                            <i class="fal fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" align="center">No Record Found!</td>
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
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('js')
    <script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        /* demo scripts for change table color */
        /* change background */


        $(document).ready(function()
        {
            $('#dt-basic-example').dataTable(
            {
                responsive: true
            });

        });

        function previewFile() {
            var preview = document.getElementById('blah');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();
            reader.addEventListener('load', function(e) {
                preview.src = e.target.result;
                preview.onload = function() {
                    console.log('Image Loaded');
                };
            }, false);

            if(file) {
                reader.readAsDataURL(file);
            }
        }

    </script>
@endpush