@extends('layouts.app')

@section('page_title') Member Location @stop

@section('content')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name')}}</a></li>
        <li class="breadcrumb-item">@yield('page_title')</li>
        <li class="breadcrumb-item active">Map</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <div id="map"></div>
            <div id="panel-1" class="panel">
                <div class="panel-container show">
                    <div class="panel-content">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        #map {
            height: 500px;
        }
    </style>
@endpush

@push('js')
  <script type="text/javascript">
    var map, latLng, marker;
    var lati = null;
    var longi = null;

    function initMap() {

      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function (position) {
            lati = position.coords.latitude;
            longi = position.coords.longitude;
          });
      } else {
          alert("You don't support this");
      }

      map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: new google.maps.LatLng(lati,longi),
          gestureHandling: 'greedy',
          tilt: 80,
          bearing: 30,
        });

      <?php for($i=0;$i<count($members);$i++) { ?>

        latLng = new google.maps.LatLng(<?php echo $members[$i]['lat'].','.$members[$i]['lng']; ?>);
        marker = new google.maps.Marker({
          position: latLng,
          map: map,
          title: "<?php echo $members[$i]['fullname'];?> \n <?php echo $members[$i]['address'];?>"
        });
      <?php }?>
    }
  </script>
  <script defer src="https://maps.googleapis.com/maps/api/js?key={{config('app.API_KEY')}}&callback=initMap"></script>
@endpush