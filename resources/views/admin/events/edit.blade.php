@extends('layouts.app')


@section('title') Editar Evento -  @endsection

@section('content')
    <div class="row">
        <div class="col-12 my-5">
            <h2>Editar Evento</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <form action="{{route('admin.events.update', ['event' => $event->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">

                    <label>Título Evento</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$event->title}}">

                    @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Descrição Rápida Evento</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{$event->description}}">

                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Fale mais Sobre o Evento</label>
                    <textarea name="body" id="" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror">{{$event->body}}</textarea>

                    @error('body')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Quando Vai Acontecer?</label>
                    <input
                        type="text"
                        class="form-control @error('start_event') is-invalid @enderror"
                        name="start_event"
                        value="{{$event->start_event->format('d/m/Y H:i')}}"
                    >

                    @error('start_event')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                </div>

                <div class="row">
                    <div class="col-12 my-3">
                        <h4>Banner do Evento</h4>
                        <hr>
                    </div>
                    <div class="col-4">
                        <img
                            src="{{ $event->banner ? asset('storage/'. $event->banner) : 'https://via.placeholder.com/1024x480.png/001177?text=Sem+Image' }}"
                            alt="Banner do Evento {{ $event->title }}"
                            class="img-fluid"
                        >
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="banner">Carregar um banner para o Evento</label>
                            <input type="file" name="banner" id="banner" class="form-control bg-warning {{ ($errors->has('banner') ? 'is-invalid' : '') }}">

                            @if ($errors->has('banner'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('banner') as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>

                <div class="form-group">
                    <label>Categoria do Evento</label>
                    <select type="text" class="form-control" multiple name="categories[]">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if($event->categories->contains($category))
                                    selected
                                @endif
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-lg btn-success">Atualizar Evento</button>

            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        el = document.querySelector('input[name=start_event]');

        let im = new Inputmask('99/99/9999 99:99');
        im.mask(el);
    </script>
@endsection
