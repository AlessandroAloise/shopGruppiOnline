@extends('layouts.basic')
@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 90vh;">
<img style="max-width: 50%; height: auto;" src="/storage//logo.png" alt="logo">
<div class="centered-div" style="width: 50%; text-align: center;">
   <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-3">
         <label for="name" class="form-label">Nome</label>
         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
         @error('name')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="surname" class="form-label">Cognome</label>
         <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
         @error('surname')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="email" class="form-label">Email</label>
         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
         @error('email')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="password" class="form-label">{{ __('Password') }}</label>
         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
         @error('password')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="password-confirm" class="form-label">Conferma Password</label>
         <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
      </div>
      <button style="padding: 12px 36px; line-height: 1.5; border-radius: 0.3rem;" type="submit" class="btn btn-primary btn-lg">Registrati</button>
   </form>
</div>
@endsection