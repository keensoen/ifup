@extends('layouts.app')

@section('page_title') Gateway @Stop

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
                    <form novalidate="" method="POST" action="{{ route('gateway.store')}}">
                @else
                    <form novalidate="" method="POST" action="{{ route('gateway.update', $gateway['id'])}}">
                @endif
                    @csrf
                    <div class="form-group">
                        <select name="organization_id" id="organization_id" class="form-control">
                            @foreach ($organization as $id => $org)
                                <option value="{{$id}}" selected> {{ $org }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" id="url" name="url" class="form-control" placeholder="Gateway URL " @if(!$flag) value="{{$gateway['url']}}" @endif>
                    </div>
                    <div class="form-group">
                        <input type="text" id="token" name="token" class="form-control" placeholder="Api Token" @if(!$flag) value="{{$gateway['token']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="routing" name="routing" class="form-control" placeholder="Routing" @if(!$flag) value="{{$gateway['routing']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="type" name="type" class="form-control" placeholder="Type" @if(!$flag) value="{{$gateway['type']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" @if(!$flag) value="{{$gateway['username']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="text" id="password" name="password" class="form-control" placeholder="Password" @if(!$flag) value="{{$gateway['password']}}" @endif>
                    </div>
                    <div class="form-group">
                        <input type="text" id="sender_id" name="sender_id" class="form-control" placeholder="Sender ID" @if(!$flag) value="{{$gateway['sender_id']}}" @endif>
                    </div>
                    <div class="form-group">
                        <input type="text" id="signature" capitalize name="signature" maxlength="25" class="form-control" placeholder="Signature" @if(!$flag) value="{{$gateway['signature']}}" @endif>
                    </div>
                @if($flag)
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary btn-md" >
                            <i class="fal fa-plus"></i> Add
                        </button>
                    </div>
                @else
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('gateway') }}" class="btn btn-primary btn-md">
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
                                <th>{{ __('Gateway URL') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Sender ID') }}</th>
                                <th width="10" align="center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($gateways as $item)
                                <tr>
                                    <td>{{ $item['url'] }}</td>
                                    <td>{{ $item['username'] }}</td>
                                    <td>{{ $item['sender_id'] }}</td>
                                    <td width="10" align="center">
                                        <a href="{{route('gateway.edit', $item['id'])}}" class="btn btn-info btn-xs btn-icon rounded-circle">
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

            $('.js-thead-colors a').on('click', function()
            {
                var theadColor = $(this).attr("data-bg");
                console.log(theadColor);
                $('#dt-basic-example thead').removeClassPrefix('bg-').addClass(theadColor);
            });

            $('.js-tbody-colors a').on('click', function()
            {
                var theadColor = $(this).attr("data-bg");
                console.log(theadColor);
                $('#dt-basic-example').removeClassPrefix('bg-').addClass(theadColor);
            });

        });

    </script>
@endpush