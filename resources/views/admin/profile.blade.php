@extends('layouts.app')

@section('title') Perfil  @endsection

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <form action="{{ route('admin.profile.update') }}" method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">
                        <h3>Dados de Acesso</h3>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Nome Completo</label>
                    <input
                        type="text"
                        name="user[name]"
                        class="form-control {{ ($errors->has('user.name') ? 'is-invalid' : '') }}"
                        value="{{ $user->name }}"
                    >
                    @error('user.name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input
                        type="text"
                        name="user[email]"
                        class="form-control" value="{{ $user->email }} {{ ($errors->has('user.email') ? 'is-invalid' : '') }}"
                    >
                    @error('user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Senha</label>
                    <input
                        type="password"
                        name="user[password]"
                        class="form-control {{ ($errors->has('user.password') ? 'is-invalid' : '') }}"
                        placeholder="Se você quiser alterar sua senha, preencha este campo e confirme abaixo"
                        autocomplete="off"

                    >
                    @error('user.password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Confirmar Senha</label>
                    <input type="password" name="user[password_confirmation]" class="form-control"
                        autocomplete="off"
                    >
                </div>

                @if($user->profile)
                    <div class="row">
                        <div class="col-12">
                            <h3>Dados de Perfil</h3>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Sobre</label>
                        <textarea name="profile[about]" id="" cols="30" rows="10" class="form-control">{{ $user->profile->about }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Contato</label>
                        <input
                            type="tel"
                            name="profile[phone]"
                            class="form-control"
                            value="{{ $user->profile->phone }}"
                        >
                    </div>

                    <div class="form-group">
                        <h3>Redes Sociais</h3>
                        @php $socialNetworks = $user->profile->social_networks @endphp
                        <div class="form-group">
                            <label for="">Facebook</label>
                            <input
                                type="text"
                                class="form-control"
                                name="profile[social_networks][facebook]"
                                value="{{ array_key_exists('facebook', $socialNetworks) ? $socialNetworks['facebook'] : null}}"
                                placeholder="Facebook"
                            >
                        </div>

                        <div class="form-group">
                            <label for="">Twitter</label>
                            <input
                                type="text"
                                class="form-control"
                                name="profile[social_networks][twitter]"
                                value="{{ array_key_exists('twitter', $socialNetworks) ? $socialNetworks['twitter'] : null}}"
                                placeholder="Twitter"
                            >
                        </div>

                        <div class="form-group">
                            <label for="">Instagram</label>
                            <input
                                type="text"
                                class="form-control"
                                name="profile[social_networks][instagram]"
                                value="{{ array_key_exists('instagram', $socialNetworks) ? $socialNetworks['instagram'] : null}}"
                                placeholder="Instagram"
                            >
                        </div>
                    </div>
                @endif
                <button class="btn btn-success btn-lg">Atualizar Perfil</button>
            </form>
        </div>
    </div>
@endsection
