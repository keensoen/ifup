@extends('layouts.app')

@section('page_title') Send SMS @Stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Management</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="row no-gutters">
        <div class="col-sm-12 col-lg-5 col-xl-5">
            <div class="card mb-g">
                <div class="card-body">
                    <div class="panel-tag">
                        <h5>@yield('page_title')</h3>
                    </div>
                    <div class="panel-content">
                        {!! Form::open(['method' => 'POST', 'route' => ['sendSMS'], 'novalidate' => '', 'autocomplete' => 'off']) !!}
                            @csrf
                            <div class="form-group">
                                <select name="recipient_check" class="select2 form-control" id="customRecipient" data-select2-id="multiple-placeholder" tabindex="-1" aria-hidden="true">
                                    <option value="null">Select an option</option>
                                    <option value="all">ALL</option>
                                    <option value="custom">Custom</option>
                                    <option value="member_group">Member Group</option>
                                    <option value="member_list">Specific Members</option>
                                </select>
                            </div>
                            <div class="form-group" id="custom">
                                <input type="text" class="form-control" name="manaul_recipient" placeholder="Enter numbers separated by comma">
                            </div>
                            <div class="form-group" id="member_list">
                                <select name="recipient[]" class="select2-placeholder-multiple form-control" multiple="" data-select2-id="multiple-placeholder" tabindex="-1" aria-hidden="true">
                                    @foreach ($members as $number => $member)
                                        <option value="{{ $number }}"> {{ $member }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="member_group">
                                <select name="recipients[]" class="select2-placeholder-multiple form-control" multiple="" data-select2-id="multiple-placeholder" tabindex="-1" aria-hidden="true">
                                    @foreach ($member_groups as $id => $group)
                                        <option value="{{ $id }}"> {{ $group }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="message" class="form-control" rows=7 maxlength="120" onkeyup="countChars(this)" placeholder="Your message"></textarea>
                                <p id="counter" class="form-control"></p>
                            </div>
                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary btn-md" >
                                    <i class="fal fa-forward"></i> Send
                                </button>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-7 col-xl-7">
            <div class="card mb-g">
                <div class="card-body">
                    <div class="panel-tag">
                        <h5>Recently Sent Recipient</h5>
                    </div>
                    <div class="panel-content">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th width="3">{{ __('s/N') }}</th>
                                    <th>{{ __('Fullname') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentLogs as $i => $item)
                                    <tr>
                                        <td width="3">{{ ++$i }}</td>
                                        <td>{{ $item->member['fullname'] }}</td>
                                        <td>{{ $item->member['tel'] }}</td>
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
    </div>
@endsection

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/fa-brands.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
    <style type="">
        text-block: {
            visibility: hidden;
        }
    </style>
@endpush

@push('js')
    <script src="{{ URL::to('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ URL::to('js/formplugins/select2/select2.bundle.js') }}"></script>
    <script>
        $(function()
        {
            $('#custom').hide();
            $('#member_list').hide();
            $('#member_group').hide();

            $('#dt-basic-example').dataTable(
            {
                responsive: true
            });
        });

        $('.select2').select2();

        $(".select2-placeholder-multiple").select2(
        {
            placeholder: "Select Member"
        });

        function icon(elm)
        {
            elm.element;
            return elm.id ? "<i class='" + $(elm.element).data("icon") + " mr-2'></i>" + elm.text : elm.text
        }

        $('#customRecipient').change(function(){
            if($('#customRecipient').val() == 'all') {
                $('#custom').hide();
                $('#member_list').hide();
                $('#member_group').hide();
            }
            else if($('#customRecipient').val() == 'custom'){
                $('#custom').show();
                $('#member_list').hide();
                $('#member_group').hide();
            }
            else if($('#customRecipient').val() == 'member_list'){
                $('#custom').hide();
                $('#member_list').show();
                $('#member_group').hide();
            }
            else if($('#customRecipient').val() == 'member_group') {
                $('#custom').hide();
                $('#member_list').hide();
                $('#member_group').show();
            }
        });

    </script>
    <<script>
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