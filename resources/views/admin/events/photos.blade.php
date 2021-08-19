@extends('layouts.app')

@section('title') Fotos  @endsection

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <form action="{{ route('admin.events.photos.store', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photos" class="font-weight-bold">Upload das Fotos do Evento</label>
                    <input
                        type="file"
                        name="photos[]"
                        id="photos"
                        class="form-control bg-warning {{ ($errors->has('photos.*') ? 'is-invalid' : '') }}"
                        multiple
                    >
                    @error('photos.*')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @endif
                </div>
                <button class="btn btn-lg btn-success">Enviar Foto do Evento</button>
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        @forelse ($event->photos as $photo)
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <img src="{{ asset('storage/'. $photo->photo) }}" alt="Foto do evento: {{ $event->title }}" class="img-fluid">
                <form action="{{ route('admin.events.photos.destroy', [$event, $photo]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button
                        class="btn btn-danger btn-sm mt-1 btn-block"
                        onclick="return confirm('Você deseja realmente remover esta foto')"
                    >
                        Remover Foto
                    </button>
                </form>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Nenhuma foto registrada para este evento</div>
            </div>
        @endforelse
    </div>
@endsection
