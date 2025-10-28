@extends('layouts.app')

@section('content')
    <div class="container-auth">
        <a href="{{ url()->previous() }}"><img src="{{ asset('images/back.png') }}" alt="back" width="47px"
                class="back"></a>
        <div class="header-content mt-4 d-flex">
            <img src="{{ asset('images/logo-text-dark.png') }}" alt="logo" width="182px">
        </div>
        <div class="box-form mt-2">
            <h3>MASUK</h3>
            <form action="{{ route('login') }}" method="POST" class="mt-5">
                @csrf
                <div class="mb-4 w-100">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4 w-100">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="pass">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="button">
                    <button type="submit" class="btn-auth">
                        {{ __('MASUK') }}
                    </button>
                    <a href="{{ route('register') }}" class="btn-auth">DAFTAR</a>
                </div>
            </form>
        </div>
    </div>
@endsection
