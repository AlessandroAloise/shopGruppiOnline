@extends('layouts.app')

@section('content')
<div>  
  <div style="width: 100%; height:100%; float: left;">
        <h1> Lista gruppi  </h1>
        <tbody>
                <!--Visualizza tutti i gruppi-->
                <table class="table table-striped">
                <tr>
                    <th>Nome</th>
                    <th>Termine 1</th>
                    <th>Termine 2</th>
                    <th>Stato Richiesta</th>
                </tr>
                @foreach ($groups as $group)
                    @if ($group->deadline1 >= date("Y-m-d"))
                    <tr>
                        <td class="col-3">{{$group->name}}</td>
                        <td class="col-3">{{ date('d.m.Y', strtotime($group->deadline1)) }}</td>
                        <td class="col-3">{{ date('d.m.Y', strtotime($group->deadline2)) }}</td>
                        <td class="col-3">
                        <form action="{{ route('requestAccessSend') }}" method="POST">
                        <input type="hidden" name="groupId" value="{{ $group->id }}">
                            @csrf
                            @if ($group->request == 1)
                                <div  class="btn btn-primary"  style="background-color: #4CAF50; border: none; ">Partecipante</div>
                            @elseif ($group->request == 0)
                                <div class="btn btn-primary" style="background-color: #ffcc00; border: none;">in attesa</div> 
                            @else
                                <button type="submit" class="btn btn-primary">Richiedi accesso</button>
                               
                            @endif
                        </form>
                    </td>
                    </tr>
                    @endif
                @endforeach
        </tbody>
    </table>
  </div>
  
</div>
@endsection
