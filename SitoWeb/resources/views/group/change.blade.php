@extends('layouts.app')

@section('content')
<div>  
  <div style="width: 100%; height:100%; float: left;">
        <h1> Lista gruppi partecipante </h1>
        <tbody>
                <!--Visualizza tutti i gruppi e le sue relative azioni-->
                <table class="table table-striped">
                <tr>
                    <th>Nome</th>
                    <th>Termine1</th>
					<th>Termine2</th>
                    <th>Azioni</th>
                </tr>
                @foreach ($groups as $group)
                    <tr>
                        <td class="col-3">{{$group->name}}</td>
                        <td class="col-3">{{ date('d.m.Y', strtotime($group->deadline1)) }}</td>
						 <td class="col-3">{{ date('d.m.Y', strtotime($group->deadline2)) }}</td>
                        <td class="col-2">
                        <form action="{{ route('order') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="groupId" value="{{ $group->idGroup }}">
                            <button type="submit" class="btn btn-primary">Ordina</button>
                        </form>
                        @if($group->idGroupLeader == Auth::user()->id)
                            <form action="{{ route('pageManagerProduct') }}" method="POST" style="display: inline;">
                            @csrf
                                <input type="hidden" name="groupId" value="{{ $group->idGroup }}">
                                <button type="submit" class="btn btn-primary">Gestisci Gruppo</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
  </div>
  
</div>
@endsection
