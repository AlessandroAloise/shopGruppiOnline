@extends('layouts.app')
@section('content')
<div style="float: left; display: flex; flex-direction: column; height: 50%; width: 100%; ">
         <h1> Richieste di accesso al gruppo </h1>
         <!--Visualizza tutte le richieste-->
         <tbody>
            <table class="table table-striped">
               <tr>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Richiesta</th>
               </tr>
               @foreach ($accessRequests as $accessRequest)
               <tr>
                  <td class="col-3">{{$accessRequest->name}}</td>
                  <td class="col-3">{{$accessRequest->surname}}</td>
                  <td class="col-3">
                     <form action="{{ route('setParticipations') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idUser" value="{{$accessRequest->idUser}}">
                        <input type="hidden" name="idGroup" value="{{$group->id}}">
                        <button type="submit" name="action" value="1" style="background-color: rgb(0, 204, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Accetta</button>
                        <button type="submit" name="action" value="0" style="background-color: rgb(255, 0, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Rifiuta</button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </table>
         </tbody>
      </div>
@endsection
