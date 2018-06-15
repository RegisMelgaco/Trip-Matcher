@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card sticky-top sticky-top-mt-5">
                    <div class="card-header">
                        <h5>Selecionado: {{ $trip->user_name }} (@lang("trip.{$trip->mode_name}"))</h5>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Origem: {{ $trip->start_address }}
                        </li>
                        <li class="list-group-item">
                            Destino: {{ $trip->end_address }}
                        </li>
                        <li class="list-group-item">
                            Horário: {{ $trip->schedule->format('H:i') }} - {{ $trip->end_time }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                @if($trips->count() == 0)
                    <h2 class="text-center font-weight-light font-italic">
                        Não há viagens compatíveis <i class="fa fa-frown-o" aria-hidden="true"></i>
                    </h2>
                @endif

                @foreach ($trips as $match)
                    <div class="card mb-3 border-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5>@lang("trip.{$match->mode_name}"): {{ $match->user_name }}</h5>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Origem: {{ $match->start_address }} ({{ $match->distanceToStart($trip->start_location) }} m)
                            </li>
                            <li class="list-group-item">
                                Destino: {{ $match->end_address }}  ({{ $match->distanceToEnd($trip->end_location) }} m)
                            </li>
                            <li class="list-group-item">
                                Horário: {{ $match->schedule->format('H:i') }} - {{ $match->end_time }}
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection