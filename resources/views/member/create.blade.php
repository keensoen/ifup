@extends('layouts.app')

@section('page_title') Create Member @stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Management</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

<div class="row">
    <div class="col-xl-6">
        <div id="panel-5" class="panel">
            <div class="panel-container show">
                <hr>
                <div style="background:gray;color:white; margin-left:10px;">
                    <h1 class="">Biodata</h1>
                </div>
                <div class="panel-content p-0">
                    <form class="needs-validation" novalidate autocomplete="off" method="POST" action="{{ route('comrades.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('member._form')
                        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                            <button class="btn btn-primary ml-auto" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/theme-demo.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::to('css/fa-regular.css') }}">
@endpush

@push('js')
    <script src="{{ URL::to('js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::to('js/formplugins/inputmask/inputmask.bundle.js') }}"></script>
    <script>
        // Class definition

        var controls = {
            leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
            rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
        }

        var runDatePicker = function()
        {

            $('#datepicker-4-2').datepicker(
            {
                orientation: "bottom right",
                todayHighlight: true,
                templates: controls
            });
        }

        $(document).ready(function()
        {
            runDatePicker();

            var i = 1;

            $('#add').click(function(){
                i++;

                $('#dynamic_field').append('<tr id="row'+i+'"><td width="700"><div class="form-row"><div class="col-12 mb-3"><input type="text" class="form-control" id="prayer_point" name="prayer_point[]" placeholder="Prayer Point"></div></div></td><td><div class="form-row"><div class="col-12 mb-3"><button" class="btn btn-danger ml-auto btn_remove" name="remove" id="'+i+'">X</button></div></div></td></tr>');
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr('id');
                $('#row'+button_id+'').remove();
            });

            $(":input").inputmask();
        });

        function visitFunction() {
            var visited = document.getElementById('like_visited');
            var visitDetail = document.getElementById('availability1');

            if(visited.checked == true) {
                visitDetail.style.display = 'block';
            }
            else {
                visitDetail.style.display = 'none';
            }
        }

        function baptizedFunction() {
            var baptized = document.getElementById('baptized');
            var pastLife = document.getElementById('life_experience');

            if(baptized.checked == true) {
                pastLife.style.display = 'block';
            }
            else {
                pastLife.style.display = 'none';
            }
        }

        function commentFunction() {
            var comment1 = document.getElementById('comment1');
            var comment = document.getElementById('comment');

            if(comment1.checked == true) {
                comment.style.display = 'block';
            }
            else {
                comment.style.display = 'none';
            }
        }

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
    <script type="javascript/text">
        function readURL(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#blah').attr('src'. e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#photo').change(function(){
            readURL(this);
        });

        $('#addRow').on('click', function(){
            addNewRow();
        })

        function addNewRow() {
            alert('Test');
        }
    </script>
@endpush