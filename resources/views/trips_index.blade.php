@extends('layouts.app')

@section('content')
<div class="container">
	{!! Form::open(['action' => 'TripsController@index', 'method' => 'GET']) !!}
		<div class="form-group row">
			<div class="col col-auto">
				{!! Form::label('dataConsulta', 'Data da Consulta:', ['class'=>'h2 mb-auto']) !!}
			</div>
			<div class="col col-auto">
				<input type="date" name="dataConsulta" class="form-control col h4">
			</div>
			<div class="col col-auto">
				{!! Form::submit('Pesquisar', ['class'=>'btn btn-primary']) !!}
			</div>
		</div>
	{!! Form::close() !!}
	@if($trips)
		<div class="row mh-100">
			<div id="map" class="col col-md-8 rounded mh-100"></div>
			<div class="col col-sm-10 col-md-4">
			  	@for ($i = 0; $i < count($trips); $i++)
			    	@if($trips[$i]['mode'] == 1)
						<div class="card mb-3 border-primary">
							<div class="card-header">
								<div class="row">
									<div class="col-sm-10">
			    						<h5>Motorista: {{ $trips[$i]['user']['name'] }}</h5>
									</div>
									<div class="col-sm-2">
			    						<a class="btn btn-info rounded-circle" href="{{ route('tripRoute', ['id' => $i, 'date' => substr($trips[$i]['schedule'],0,10)]) }}" role="button">+</a>
									</div>
								</div>
	    			@else
	    				<div class="card mb-3 border-success">
							<div class="card-header">
			    				<div class="row">
									<div class="col-sm-10">
			    						<h5>Caroneiro: {{ $trips[$i]['user']['name'] }}</h5>
									</div>
									<div class="col-sm-2">
			    						<a class="btn btn-info rounded-circle" href="{{ route('tripRoute', ['id' => $i, 'date' => substr($trips[$i]['schedule'],0,10)]) }}" role="button">+</a>
									</div>
								</div>
    				@endif
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								Origem: {{ $trips[$i]['start_address']['address'] }}
							</li>
							<li class="list-group-item">
								Destino: {{ $trips[$i]['end_address']['address'] }}
							</li>
						</ul>
					</div>
				@endfor
			</div>
		</div>
	@endif
</div>
@endsection
@section('scripts')
	@if($trips)
    <script>
    	var trips = {!! json_encode($trips) !!};

    	window.initMap = function() {
			var brasil = {lat: -10.6558907, lng: -58.7343253};
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 4,
				center: brasil
			});
			var locations = [];
			for (var i = trips.length - 1; i >= 0; i--){
				locations[i*2] = trips[i]['end_address']['location'];
				locations[i*2+1] = trips[i]['start_address']['location'];
			}
			var markers = locations.map(function(location, i) {
	          return new google.maps.Marker({
	            position: location
	          });
	        });
			var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
		}
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmW3t-pRDW2Xvcqxzyghp5hMBmkuhe7u4&callback=initMap">
    </script>
    @endif
@endsection