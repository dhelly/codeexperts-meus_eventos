@extends('layouts.site')

@section('title') {{ $event->title }} @endsection

@section('content')

@if($event->banner)
    <div class="row mb-3">
        <div class="col-12 align">
            <img
                class="img-fluid d-block ml-auto mr-auto"
                src="{{ asset('storage/'. $event->banner ) }}"
                alt="Banner do Evento: {{ $event->title }}"
            >
        </div>
    </div>
@endif

<div class="row mt-5">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2>Evento: {{ $event->title }}</h2>
            <p>
                Evento acontecerá em {{ $event->start_event->format('d/m/Y H:i:s') }}
            </p>
        </div>
        <div>
            <a href="{{ route('enrollment.start', $event->slug) }}" class="btn btn-ln btn-success">Inscrever-se</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab"
                    aria-controls="nav-about" aria-selected="true">Sobre</a>
                @if($event->photos->count())
                <a class="nav-link" id="nav-photos-tab" data-toggle="tab" href="#nav-photos" role="tab"
                    aria-controls="nav-photos" aria-selected="false">Fotos</a>
                @endif
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-2" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                {{ $event->body }}
            </div>

            @if($event->photos->count())
            <div class="tab-pane fade pt-2" id="nav-photos" role="tabpanel" aria-labelledby="nav-photos-tab">
                <div class="row">
                    @foreach ($event->photos as $photo)
                    <div class="col-3">
                        <img src="{{ $photo->photo }}" alt="Foto do evento {{ $event->title }}" class="img-fluid">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>

    </div>
</div>
@endsection
