@extends('admin.layouts.master')
@section('content')
@include('admin.includes.messages')




<div class="container">
    <h1 class="mb-4">{{ __('Order Details') }}</h1>

    <div class="card mb-4">
      <div class="card-header">
        <h4 class="card-title mb-0">{{ __('Order Information') }}</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <p><strong>{{ __('Order Number') }}:</strong> {{ $row->order_num }}</p>
            <p><strong>{{ __('Order Date') }}:</strong> {{ $row->created_at }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>{{ __('Client') }}:</strong> {{ @$row->customer->name }}</p>
            <p><strong>{{ __('Client Mobile') }}:</strong> {{ @$row->customer->mobile }}</p>
            <p id='client'><strong>{{ __('location') }}:</strong> <i class="icofont-location-pin fs-5"></i></p>
                            <div id="mapclient" style="height: 400px;">   <iframe
                                width="300"
                                height="300"
                                frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?q={{@$row->customer->address[0]->lat}}%2C+{{@$row->customer->address[0]->lng}}&key=AIzaSyCPdJEEMbL34FbOOYkpMzQOOcX1d7tQ6FQ" allowfullscreen>
                              </iframe>   </div>
          </div>
          <div class="col-md-4">
            <p><strong>{{ __('Family') }}:</strong> {{ @$row->provider->name }}</p>
            <p><strong>{{ __('Mobile') }}:</strong> {{  @$row->provider->mobile }}</p>

            <p id='provider'><strong>{{ __('location') }}:</strong> <i class="icofont-location-pin fs-5"></i></p>
            <div id="mapprovider" style="height: 400px;"> <iframe
                width="300"
                height="300"
                frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/place?q={{@$row->provider->address[0]->lat}}%2C+{{@$row->provider->address[0]->lng}}&key=AIzaSyCPdJEEMbL34FbOOYkpMzQOOcX1d7tQ6FQ" allowfullscreen>
            </iframe>   </div></div>

    </div>
</div>
</div>


<div class="card mb-4">
    <div class="card-header">
       <h4 class="card-title mb-0">{{ __('Details') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{-- @php
                $prepare_time=0;
                     foreach ($row->orderProducts as $item)
                        {
                            $prepare_time += $item->product->prepare_time;
                        }
                @endphp --}}
                <p><strong>{{ __('Preparnig Time') }}:</strong> {{ $row->preparing_start_time }}</p>
                <p><strong>{{ __('delivery Time') }}:</strong> {{ $row->delivery_time ?? '00:00:00' }}</p>
            </div>
            <div class="col-md-4">
                <p><strong>{{ __('Pickup Time') }}:</strong> {{ @$row->pickup_time }}</p>
                <p><strong>{{ __('Payment Method') }}:</strong> {{ @$row->payment->title }}</p>
            </div>

        </div>
    </div>

</div>



    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">{{ __('Items') }}</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Subtotal') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($row->orderProducts as $item)
                <tr>
                  <td>{{ $item->product->title }}</td>
                  <td>{{ @$item->amount }}</td>
                  <td>{{ $item->count }}</td>
                  <td>{{ $item->total_amount }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td><strong>{{ __('Total') }}:</strong> {{ $row->total_amount }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>





        <div class="card mb-4">
            <div class="card-header">
              <h4 class="card-title mb-0">{{ __('Fees') }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    {{-- @php
                    $prepare_time=0;
                         foreach ($row->orderProducts as $item)
                            {
                                $prepare_time += $item->product->prepare_time;
                            }
                    @endphp --}}
                  <p><strong>{{ __('Provider Fees') }}:</strong> {{ $row->provider_fees}}</p>


                </div>
                <div class="col-md-12">
                    <p><strong>{{ __('Company Fees') }}:</strong> {{ $row->company_fees}}</p>
                </div>

              </div>
            </div>

    </div>

  </div>
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0qEvGL429gokwoE2PYynkguNyPSPrIlk"></script> --}}


  <script>
     $('#mapclient,#mapprovider').hide();
$('#client').click(function(){
    $('#mapclient').toggle();

});
$('#provider').click(function(){
    $('#mapprovider').toggle();

});

    // function initMap() {
      // Create a new map object centered on the desired location
    //   var map_client = new google.maps.Map(document.getElementById('mapclient'), {
    //     center: {lat: {{@$row->customer->address[0]->lat}}, lng: {{@$row->customer->address[0]->lng}} },
    //     zoom: 12
    //   });
    //   var map_provider = new google.maps.Map(document.getElementById('mapprovider'), {
    //     center: {lat: {{@$row->provider->address[0]->lat}}, lng: {{@$row->provider->address[0]->lng}} },
    //     zoom: 12
    //   });

    //   // Add a marker to the desired location
    //   var marker = new google.maps.Marker({
    //     position: {lat: {{@$row->customer->address[0]->lat}}, lng: {{@$row->customer->address[0]->lng}} },
    //     map: map_client,
    //     title: 'Client Location'
    //   });
    //   // Add a marker to the desired location
    //   var marker = new google.maps.Marker({
    //     position: {lat: {{@$row->provider->address[0]->lng}}, lng: {{@$row->provider->address[0]->lng}} },
    //     map: map_provider,
    //     title: 'Family Location'
    //   });
    // }


    function initMap() {
  var latLng = {lat: {{$row->customer->address[0]->lat}}, lng: {{$row->customer->address[0]->lng}}}; // set the latitude and longitude
  var map = new google.maps.Map(document.getElementById('mapclient'), {
    zoom: 8, // set the zoom level
    center: latLng, // set the center of the map to the specified latitude and longitude
  });
  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
  });
}
  </script>
  <script async defer onload="initMap()"></script>
  {{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0qEvGL429gokwoE2PYynkguNyPSPrIlk&callback=initMap"></script> --}}
@stop
