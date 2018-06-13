@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card sticky-top sticky-top-mt-5">
                    <div class="card-header">
                        <h5>Selecionado: {{ $trip['user']['name'] }}</h5>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Origem: {{ $trip['start_address']['address'] }}
                        </li>
                        <li class="list-group-item">
                            Destino: {{ $trip['end_address']['address'] }}
                        </li>
                        <li class="list-group-item">
                            Horário: {{ $trip['schedule'] }} - {{ $trip['end_schedule'] }}
                        </li>
                        <li class="list-group-item">
                            Empresa: {{ $trip['user']['company'] }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                @if(empty($trips))
                    <h2 class="text-center font-weight-light font-italic">Não há viagens compatíveis <i class="fa fa-frown-o" aria-hidden="true"></i></h2>
                @else
                    @for ($i = 0; $i < count($trips); $i++)
                        @if($trips[$i]['mode'] == 1)
                            <div class="card mb-3 border-primary">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <h5>Motorista: {{ $trips[$i]['user']['name'] }}</h5>
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
                                    <li class="list-group-item">
                                        Horário: {{ $trips[$i]['schedule'] }} - {{ $trip['end_schedule'] }}
                                    </li>
                                    <li class="list-group-item">
                                        Empresa: {{ $trips[$i]['user']['company'] }}
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
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item">
                                        Origem: {{ $trips[$i]['start_address']['address'] }}
                                    </li>
                                    <li class="list-group-item">
                                        Destino: {{ $trips[$i]['end_address']['address'] }}
                                    </li>
                                    <li class="list-group-item">
                                        Horário: {{ $trips[$i]['schedule'] }} - {{ $trip['end_schedule'] }}
                                    </li>
                                    <li class="list-group-item">
                                        Empresa: {{ $trips[$i]['user']['company'] }}
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endfor
                @endif
            </div>
        </div>
    </div>
@endsection