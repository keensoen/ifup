@extends('layouts.app')

@section('page_title') SMS Template @Stop

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
                @if($flag)
                    {!! Form::open(['method' => 'POST', 'route' => ['templates.store'], 'novalidate' => '']) !!}
                @else
                    {!! Form::model($template, ['method' => 'PATCH', 'route' => ['templates.update', $template->id], 'novalidate' => '']) !!}
                @endif
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
                        {!! Form::textarea('message_temp', null, ['class'=> 'form-control', 'id'=>'message', 'rows' => 7,'maxLength'=>120, 'onkeyup'=>'countChars(this)', 'placeholder' => 'Birthday Wish']) !!}
                        <p id="counter" class="form-control"></p>
                    </div>
                @if($flag)
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary btn-md" >
                            <i class="fal fa-plus"></i> Add
                        </button>
                    </div>
                @else
                    <div class="form-group mb-0 text-right">
                        <a href="{{ route('templates.index') }}" class="btn btn-primary btn-md">
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
                            Click here for more<i class="fal fa-arrow-right"></i>
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
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Sent Count') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th width="10" align="center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $item)
                                <tr>
                                    <td>{{ $item->month }}</td>
                                    <td>{{ $item->year }}</td>
                                    <td></td>
                                    <td>{{ $item->message_temp }}</td>
                                    <td width="10" align="center">
                                        <a href="{{ route('templates.show', $item->id) }}" class="btn btn-icon btn-success btn-xs rounded-circle"><i class="fal fa-eye"></i></a>
                                        <a href="{{ route('templates.edit', $item->id) }}" class="btn btn-icon btn-warning btn-xs rounded-circle"><i class="fal fa-check-circle"></i></a>
                                        <form method="POST", action="{{ route('templates.destroy', $item->id) }}">
                                            {{method_field('DELETE')}}
                                            {{csrf_field()}}
                                            <button type="submit" id="deleteTrigger" class="btn btn-icon btn-danger btn-xs rounded-circle" onclick="return confirm('Are you sure to delete');"><i class="fal fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" align="center">No Record Found!</td>
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
    <link rel="stylesheet" href="{{ URL::to('js/datepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('js')
    <script src="{{ URL::to('js/datepicker/moment.min.js') }}"></script>
    <script src="{{ URL::to('js/datepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function()
        {

            $('#dt-basic-example').dataTable(
            {
                responsive: true
            });
        });

    </script>
    <script>
        $(function(){
            var text_max = 120;
            $('#counter').html(text_max + ' characters remaining');

            $('#message').keyup(function() {
                var text_length = $('#message').val().length;
                var text_remaining = text_max - text_length;

                $('#counter').html(text_remaining + ' characters remaining');
            });

            $('input[name="month"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                changeMonth: true,
                changeYear: true,
                position: "top right",
                onClose: function(dateText, inst){
                    $(this).daterangepicker('month', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });
        });
    </script>
@endpush