@extends('layouts.app')

@section('content')
    <div class="container-auth">
        <a href="{{ url()->previous() }}"><img src="{{ asset('images/back.png') }}" alt="back" width="47px"
                class="back"></a>
        <div class="header-content d-flex">
            <img src=" alt="logo" width="182px">
        </div>
        <div class="box-form mt-2">
            <h3>DAFTAR</h3>
            <form method="POST" action="{{ route('register') }}" class="mt-5">
                @csrf
                <div class="mb-4 w-100">
                    <label for="name">{{ __('Username') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
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
                            name="password" required autocomplete="new-password">
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4 w-100">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <div class="pass">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                        <span toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password-confirm"></span>
                    </div>

                </div>
                <div class="button">
                    <button type="submit" class="btn-auth">
                        {{ __('DAFTAR') }}
                    </button>
                    <a href="{{ route('login') }}" class="btn-auth">MASUK</a>
                </div>
            </form>
        </div>
    </div>
@endsection
