@extends('layout.app')

@section('title') Criar Evento  @endsection

@section('content')

    <div class="row">
        <div class="col-12 my-5">
            <h2>Editar Evento</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.events.update', ['event' => $event->id]) }}" method="post">
                @csrf
                <div class="form-group mb-2">
                    <label>Titulo do Evento</label>
                    <input type="text" name="title" class="form-control" value="{{ $event->title }}">
                </div>

                <div class="form-group my-2">
                    <label>Descrição Rápida</label>
                    <input type="text" name="description" class="form-control" value="{{ $event->description }}">
                </div>

                <div class="form-group my-2">
                    <label>Fale mais sobre o Evento</label>
                    <textarea name="body" cols="30" rows="10" class="form-control">{{ $event->body }}</textarea>
                </div>

                <div class="form-group my-2">
                    <label>Quando vai acontecer</label>
                    <input type="text" name="start_event" class="form-control" value="{{ $event->start_event }}">
                </div>

                <button type="submit" class="btn btn-lg btn-success my-2">Criar Evento</button>

            </form>
        </div>
    </div>

@endsection
