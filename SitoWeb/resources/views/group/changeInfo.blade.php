@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 10%;">
   <h1>Gestione Gruppo </h1>
</div>
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 60%;">
    <div class="centered-div" style="width: 50%; text-align: center; align-items: center;">
        <form method="POST" action="{{ route('groupManagerChanges') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label">Nome</label>
                <input type="hidden" name="groupId" value="{{$groupInfo[0]->id}}">
                <input type="hidden" name="oldName" value="{{ $groupInfo[0]->name }}">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ $groupInfo[0]->name }}" maxlength="255">
                @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deadline1" class="form-label">Termine 1</label>
                <input id="deadline1" type="date" class="form-control @error('deadline1') is-invalid @enderror" name="deadline1" autocomplete="deadline1" value="{{ $groupInfo[0]->deadline1 }}" min="{{ date('Y-m-d') }}">
                @error('deadline1')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deadline2" class="form-label">Termine 2</label>
                <input id="deadline2" type="date" class="form-control @error('deadline2') is-invalid @enderror" name="deadline2" autocomplete="deadline2" value="{{ $groupInfo[0]->deadline2 }}" min="">
                @error('deadline2')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="Participants" class="form-label">Partecipanti:</label>
                <label for="ParticipantsNumber" class="form-label">{{ $participationsCount }}</label>
                <div class="btn btn_red">
                    <span class="icon"></span>
                    <a href="{{ route('listParticipants', $groupInfo[0]) }}">
                        <img alt="Richiesta" src="/storage/requestUser.png" width="30" height="30">
                    </a>
                </div>

            </div>
            <div class="mb-4">
                <label for="Participants" class="form-label">Richieste:</label>
                <label for="ParticipantsNumber" class="form-label">{{ $participationsRequestCount }}</label>
                <div class="btn btn_red">
                    <span class="icon"></span>
                    <a href="{{ route('requestAccessPage', $groupInfo[0]) }}">
                        <img alt="Richiesta" src="/storage/requestUser.png" width="30" height="30">
                    </a>
                </div>
            </div>
            <button type="submit" name="action" value="0" style="padding: 12px 36px; line-height: 1.5; border-radius: 0.3rem;" type="submit" class="btn btn-primary btn-lg">Annulla</button>
            <button type="submit" name="action" value="1" style="padding: 12px 36px; line-height: 1.5; border-radius: 0.3rem;" type="submit" class="btn btn-primary btn-lg">Salva</button>
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