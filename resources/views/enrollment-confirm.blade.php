@extends('layouts.site')

@section('title') {{ $event->title }} @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Confirmação de Inscrição</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <p>
                Evento: <strong>{{ $event->title }}</strong>
                <br>
                Dia: <strong>{{ $event->start_event->format('d/m/Y H:i') }}</strong>
            </p>

            <p>
                <a href="{{ route('enrollment.process') }}" class="btn btn-lg btn-success">Confirmar Inscrição</a>
            </p>
        </div>
    </div>
@endsection
