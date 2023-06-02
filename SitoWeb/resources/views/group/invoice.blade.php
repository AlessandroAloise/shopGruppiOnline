@extends('layouts.app')

@section('content')
<div style="display: grid; grid-template-columns: 1fr;">
    <div style="grid-column: 1;">
        <h1>Fatture</h1>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Importo</th>
                    <th>Scarica</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->surname}}</td>
                    <td>{{$user->totalSpent}} CHF</td>
                    <td>
                        <form action="{{ route('createPDF') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idUser" value="{{ $user->id}}">
							<input type="hidden" name="nameGroup" value="{{$name[0]->name}}">
                            <input type="image" id="image" alt="Login" src="/storage/download.png">
                        </form>   
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="position: fixed; bottom: 0; left: 210px; width: 100%; height: 60px; background-color: #f5f5f5; border-top: 1px solid #ddd; padding: 10px;">
        Nome gruppo: {{$name[0]->name}} <span style="float: center;">Totale ordine: {{$totalValue}}</span>
    </div>
</div>
@endsection
