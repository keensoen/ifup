@extends('layouts.app')

@section('page_title') User @Stop

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
                    <form novalidate="" method="POST" autocomplete="off" action="{{ route('user.store')}}">
                @else
                    <form novalidate="" method="POST" action="{{ route('user.update', $user['id'])}}">
                @endif
                    @csrf
                    <div class="form-group">
                        <select name="organization_id" id="organization_id" class="form-control">
                            @foreach ($organizations as $id => $name)
                                <option value="{{$id}}" selected>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="member_id" id="member_id" class="form-control">
                            @foreach ($members as $id => $name)
                                <option value="{{$id}}" selected>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="role" id="role" class="form-control">
                            @foreach ($roles as $id => $name)
                                <option value="{{$id}}" selected>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" @if(!$flag) value="{{$user['username']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="email" @if(!$flag) value="{{$user['email']}}" @endif >
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    </div>
                @if($flag)
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary btn-md" >
                            <i class="fal fa-plus"></i> Add
                        </button>
                    </div>
                @else
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('user') }}" class="btn btn-primary btn-md">
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
                            Click here to Add user<i class="fal fa-arrow-right"></i>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th width="10" align="center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr>
                                    <td>
                                        @if(!empty($item['member_id'])) 
                                            {{ $item->member->fullname }}
                                        @else
                                            @foreach($item->getRoleNames() as $role)
                                                <span>{{ \Str::upper($role) }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item['username'] }}</td>
                                    <td>{{ $item['email'] }}</td>
                                    <td>{{ $item['created_at']->format('d-m-Y') }}</td>
                                    <td width="10" align="center">
                                        <a href="{{route('user.edit', $item['id'])}}" class="btn btn-info btn-xs btn-icon rounded-circle">
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