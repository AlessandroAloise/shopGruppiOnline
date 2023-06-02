@extends('layouts.basic')

@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 90vh;">
    <img style="max-width: 50%; height: auto;" src="/storage//logo.png" alt="logo">
    <div class="centered-div" style="width: 50%; text-align: center; align-items: center;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button style="padding: 12px 36px; line-height: 1.5; border-radius: 0.3rem;" type="submit" class="btn btn-primary btn-lg">Accedi</button>
        </form>
    </div>
</div>
@endsection
