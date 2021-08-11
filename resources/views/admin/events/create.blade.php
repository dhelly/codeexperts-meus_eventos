@extends('layouts.app')

@section('title') Criar Evento  @endsection

@section('content')

    <div class="row">
        <div class="col-12 my-5">
            <h2>Criar Evento</h2>
        </div>
    </div>

    {{--
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @enderror
    --}}

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.events.store') }}" method="post">
                @csrf

                <div class="form-group mb-2">
                    <label>Titulo do Evento</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control {{ ($errors->has('title') ? 'is-invalid' : '') }}"
                        value="{{ old('title') }}"
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group my-2">
                    <label>Descrição Rápida</label>
                    <input
                        type="text"
                        name="description"
                        class="form-control {{ ($errors->has('description') ? 'is-invalid' : '') }}"
                        value="{{ old('description') }}"
                    >

                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('description') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group my-2">
                    <label>Fale mais sobre o Evento</label>
                    <textarea
                        name="body"
                        cols="30"
                        rows="10"
                        class="form-control {{ ($errors->has('body') ? 'is-invalid' : '') }}"
                    >{{ old('body') }}</textarea>

                    @if ($errors->has('body'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('body') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group my-2">
                    <label>Quando vai acontecer</label>
                    <input
                        type="text"
                        name="start_event"
                        class="form-control {{ ($errors->has('start_event') ? 'is-invalid' : '') }}"
                        value="{{ old('start_event') }}"
                    >

                    @if ($errors->has('start_event'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('start_event') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-lg btn-success my-2">Criar Evento</button>

            </form>
        </div>
    </div>

@endsection
