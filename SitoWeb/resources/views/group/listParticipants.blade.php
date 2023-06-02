@extends('layouts.app')
@section('content')
<div style="float: left; display: flex; flex-direction: column; height: 50%; width: 100%; ">
         <h1> Lista Partecipanti </h1>
         <!--Visualizza tutte le richieste-->
         <tbody>
            <table class="table table-striped">
               <tr>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Blocca</th>
               </tr>
               @foreach ($list as $user)
               <tr>
                  <td class="col-3">{{$user->name}} </td>
                  <td class="col-3">{{$user->surname}}</td>
                  <td class="col-3">
                   @csrf
                     @if($user->idUser != auth()->user()->id)
                        <form action="{{ route('block') }}" method="POST">
                           @csrf
                           <input type="hidden" name="idUser" value="{{$user->idUser}}">
                           <input type="hidden" name="idGroup" value="{{$group->id}}">
                           <button type="submit" name="action" value="0" style="background-color: rgb(255, 0, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Blocca</button>
                        </form>
                     @else
                        (Capo gruppo)
                     @endif
                  </td>
               </tr>
               @endforeach
            </table>
         </tbody>
      </div>
@endsection
