@extends('layouts.app')

@section('content')
<div>
    <div style="float: left; display: flex; flex-direction: column; height: 100%; width: 100%; ">
    <form method="POST" action="{{ route('groupCreate') }}" style="width: 75%; margin: auto;" class="ui form">
        <div style="text-align: center;">
            <h1>Crea gruppo </h1>
        </div>
        @csrf
      <div class="mb-3">
         <label for="nameGroup" class="form-label">Nome gruppo</label>
         <input id="nameGroup" type="text" class="form-control @error('nameGroup') is-invalid @enderror" name="nameGroup"  maxlength="255" value="{{ old('nameGroup') }}" required autocomplete="nameGroup" autofocus>
         @error('nameGroup')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="dline1" class="form-label">Termine1</label>
         <input id="deadline1" type="date" class="form-control @error('deadline1') is-invalid @enderror datepicker" name="deadline1" value="{{ old('deadline1') }}" required autocomplete="deadline1" min="{{ date('Y-m-d') }}">
         @error('deadline1')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
      <div class="mb-3">
         <label for="deadline2" class="form-label">Termine2</label>
         <input id="deadline2" type="date"  class="form-control @error('deadline2') is-invalid @enderror" name="deadline2" value="{{ old('deadline2') }}" required autocomplete="deadline2" min="">
         @error('deadline2')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
        <div style="text-align: center;">
            <button style="padding: 12px 36px; line-height: 1.5; border-radius: 0.3rem;" type="submit" class="btn btn-primary btn-lg">Crea Gruppo</button>
        </div>
    </form>
    </div> 
</div>

<script>
    var deadline1 = document.getElementById('deadline1');
    var deadline2 = document.getElementById('deadline2');
    
    deadline1.addEventListener('change', function() {
        var minDate = new Date(deadline1.value);
        minDate.setDate(minDate.getDate() + 1);
        var formattedMinDate = minDate.toISOString().split('T')[0];
        deadline2.min = formattedMinDate;
    });
	
	deadline2.oninput = function() {
        if (deadline2.value < deadline1.value) {
            deadline2.setCustomValidity('La data di termine 2 deve essere successiva alla data di termine 1');
        } else {
            deadline2.setCustomValidity('');
        }
    };
</script>
@endsection
