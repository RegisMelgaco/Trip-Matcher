@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="get" action="{{ route('trips.index', ['cunsult_date'=> $consult_date]) }}">
            <div class="form-group row">
                <div class="col col-auto">
                    <label for="consult_date" class="h2">Data da Consulta: </label>
                </div>
                <div class="col col-auto">
                    <input type="date" name="consult_date" value="{{ $consult_date->format('Y-m-d') }}" class="form-control">
                </div>
                <div class="col col-auto">
                    <input type="submit" value="Pesquisar" class="btn btn-primary">
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col col-md-8">
                <div id="map" class="rounded mh-100em sticky-top sticky-top-mt-5"></div>
            </div>
            <div class="col col-sm-10 col-md-4">
                @if ($trips->count() == 0)
                    Nenhuma carona agendada para o dia.
                @endif

                @foreach ($trips as $trip)
                        <div class="card mb-3 border-primary bg-primary">
                        <div class="card-header bg-primary">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5 class="text-white">@lang("trip.{$trip->mode_name}"): {{ $trip->user_name }}</h5>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-info" href="{{ route('trips.show', $trip->id) }}"
                                       role="button">+</a>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Origem: {{ $trip->start_address }}
                            </li>
                            <li class="list-group-item">
                                Destino: {{ $trip->end_address }}
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @if(!empty($trips))
        <script>
            window.trips = {!! json_encode($trips->toArray()) !!};
        </script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmW3t-pRDW2Xvcqxzyghp5hMBmkuhe7u4&callback=initMap">
        </script>
    @endif
@endsection