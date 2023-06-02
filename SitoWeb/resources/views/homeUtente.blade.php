@extends('layouts.app')

@section('content')
<h3> Ordine per gruppo: {{$groupInfo[0]->name}}</h3>
<p style="color: red; font-weight: bold;"> {{$error}}</p>
<p style="color: green; font-weight: bold;"> {{$saved}}</p>
    <tbody>
                <table class="table table-striped">
                <tr>
                    <th>Immagine<th>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Prezzo</th>
                    <th>Quantita Minima</th>
                    <th>Multiplo</th>
                    <th>Quantità</th>
                    <th>Ordina</th>
                </tr>
                @foreach ($products as $product)
                    <tr>
                    <td><div class="image-container">
                    <img  src="data:image/png;base64, {{$product->image}}" alt="Foto" class="zoom-image" width="50" height="50">
                    </div><td>                            
                        <td class="col-2">{{$product->name}}</td>
                        <td class="col-5">{{$product->description}}</td>
                        <td class="col-2">{{$product->price}} CHF</td>
                        <td class="col-5">{{$product->quantityMin}}</td>
                        <td class="col-5">{{$product->multiple}}</td>
                        <form action="{{ route('saveOrder') }}" method="POST">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <input type="hidden" name="group_id" value="{{$product->idGroup}}">
                            @csrf
                            @if ($groupInfo[0]->deadline1 < date("Y-m-d") || $groupInfo[0]->deadline2 < date("Y-m-d"))  
                                @if(($groupInfo[0]->approved == 1 && $groupInfo[0]->deadline2 >= date("Y-m-d"))|| $groupInfo[0]->idGroupLeader == auth()->user()->id)
                                    <td class="col-5"><input type="number" id="quantiy" name="quantiy" min="0" max="2147483647"  value="{{$product->userQuantity}}"></td>
                                    <td class="col-5"><input type="submit" value="Salva"></td>
                                @else
                                    <td class="col-5">{{$product->userQuantity}}</td>
                                    <td class="col-5">Attesa</td>
                                @endif
                            @elseif($groupInfo[0]->deadline1 >= date("Y-m-d"))
                                <td class="col-5"><input type="number" id="quantiy" name="quantiy" min="0" max="2147483647"  value="{{$product->userQuantity}}"></td>
                                <td class="col-5"><input type="submit" value="Salva"></td>
                            @endif
                        </form>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection

