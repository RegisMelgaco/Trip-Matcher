@extends('layouts.app')

@section('content')
<div class="container">
	<form method="get" action="{{ route('trips', ['cunsult_date'=>$consult_date->toDateString()]) }}">
		<div class="form-group row">
			<div class="col col-auto">
				<label for="consult_date" class="h2">Data da Consulta: </label>
			</div>
			<div class="col col-auto">
				<input type="date" name="consult_date" value="{{ $consult_date->toDateString() }}" class="form-control">
			</div>
			<div class="col col-auto">
				<input type="submit" value="Pesquisar" class="btn btn-primary">
			</div>
		</div>
	</form>


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
		    						<a class="btn btn-info rounded-circle" href="{{ route('trip', ['id' => $i, 'consult_date' => substr($trips[$i]['schedule'],0,10)]) }}" role="button">+</a>
								</div>
							</div>
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
    			@else
    				<div class="card mb-3 border-success">
						<div class="card-header">
		    				<div class="row">
								<div class="col-sm-10">
		    						<h5>Caroneiro: {{ $trips[$i]['user']['name'] }}</h5>
								</div>
								<div class="col-sm-2">
		    						<a class="btn btn-info rounded-circle" href="{{ route('trip', ['consult_date' => substr($trips[$i]['schedule'],0,10), 'id' => $i]) }}" role="button">+</a>
								</div>
							</div>
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
				@endif
			@endfor
		</div>
	</div>
</div>
@endsection
@section('scripts')
	@if(!empty($trips))
		<script>
			let trips = {!! json_encode($trips) !!};

			window.initMap = function() {
				let brasil = {lat: -10.6558907, lng: -58.7343253};
				let map;
				map = new google.maps.Map(document.getElementById('map'), {
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