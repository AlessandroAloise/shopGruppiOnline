@extends('layouts.app')

@section('content')
<div>
    <div style="float: left; display: flex; flex-direction: column; height: 100%; width: 100%; ">
    <form method="POST" action="{{ route('saveNewInfo') }}" style="width: 75%; margin: auto;" class="ui form">
        <div style="text-align: center;">
            <h1>Informazioni utente </h1>
        </div>
        @csrf
      <div class="mb-3">
         <label for="name" class="form-label">Nome</label>
         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user[0]->name}}" required autocomplete="name" autofocus>
         @error('name')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="surname" class="form-label">Cognome</label>
         <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror datepicker" name="surname" value="{{ $user[0]->surname}}" required autocomplete="surname">
         @error('surname')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="email" class="form-label">Email</label>
         <input id="email" type="text"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user[0]->email}}" required autocomplete="email" >
         @error('email')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
        <div style="text-align: center;">
        <button type="submit" name="action" value="0" style="background-color: rgb(255, 0, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Annulla</button>
            <button type="submit" name="action" value="1" style="background-color: rgb(0, 204, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Salva</button>
        </div>
    </form>
    </div> 
</div>
@endsection
