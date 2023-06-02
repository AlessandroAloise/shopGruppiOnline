@extends('layouts.app')
@section('content')
<div>
<div style="width: 100%; height: 10%; float: left;">

   <div style="height: 100%; width: 33.33%; float: left;">
   <form action="{{ route('invoce') }}" method="POST" style="display: inline;">
         @csrf
         <input type="hidden" name="groupId" value=" {{$groupInfo[0]->id}}">
         <button type="submit" class="btn btn-primary" type="button" style="background-color: rgb(128, 128, 128);  height: 100%; width: 100%; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Fatture</button>
      </form>
   </div>
   <div style="height: 100%; width: 33.33%; float: left;">
      <form action="{{ route('addProduct') }}" method="POST" style="display: inline;">
         @csrf
         <input type="hidden" name="groupId" value=" {{$groupInfo[0]->id}}">
         <button type="submit" class="btn btn-primary" type="button" style="background-color: rgb(128, 128, 128);  height: 100%; width: 100%; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Aggiungi Prodotto</button>
      </form>

   </div>
   <div style="height: 100%; width: 33.33%; float: left;">
      <form action="{{ route('groupInfo') }}" method="POST" style="display: inline;">
         @csrf
         <input type="hidden" name="groupId" value=" {{$groupInfo[0]->id}}">
         <button type="submit" class="btn btn-primary" type="button" style="background-color: rgb(128, 128, 128); height: 100%; width: 100%; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Gestisci Gruppo</button>
      </form>
   </div>
</div>

   <div style="width: 100%; height:90%; float: left; ">
<h1> Prodotti Gruppo {{$groupInfo[0]->name}}</h1>
      @csrf
      @if ($groupInfo[0]->deadline1 < date("Y-m-d") )
         @if($groupInfo[0]->approved == 0)  
         <form action="{{ route('approveProducts') }}" method="POST">
                  @csrf
                  <input type="hidden" name="groupId" value=" {{$groupInfo[0]->id}}">  
                  <button type="submit" class="btn btn-primary" type="button" >Approva Prodotti</button>
            </form>
         @else
            <p> Prodotti già approvati </p>
         @endif
      @endif
      
      <tbody>
         <!--Visualizza tutti i prodotti-->
         <table class="table table-striped" style="">
            <tr>
            <th>Nome</th>
			<th>Immagine</th>
            <th>Codice</th>
            <th>Prezzo</th>
            <th>Quantità minima</th>
            <th>Multiplo</th>
            <th>Visibile</th>
            <th>Quantità ordinata</th>
            <th>Modifica</th>
         </tr>
         @foreach ($products as $product)
         <tr>
            <td class="col-5">{{$product->name}}</td>
			<td><div class="image-container">
                    <img  src="data:image/png;base64, {{$product->image}}" alt="Foto" class="zoom-image" width="50" height="50">
				</div> 
			</td>
            <td class="col-2">{{$product->code}}</td>
            <td class="col-2">{{$product->price}}</td>
            <td class="col-2">{{$product->quantityMin}}</td>
            <td class="col-2">{{$product->multiple}}</td>
            <td class="col-2">
            <form action="{{ route('visibleProduct') }}" method="POST">
               @csrf
               <input type="hidden" name="idProduct" value="{{ $product->id }}">
               <input type="hidden" name="groupId" value="{{ $groupInfo[0]->id}}">
               @if ($product->visible ==0)  
               <input type="image" id="image" alt="Login"src="/storage//visible.png" >
               @else
               <input type="image" id="image" alt="Login"src="/storage//novisible.png" >
               @endif
            </form>   
            </td>
            <td class="col-2">
               @csrf
               @if ($product->totalOrderedQuantity == null)
                  0
               @else
               {{$product->totalOrderedQuantity}}
               @endif
            </td>
            <td>
               <form action="{{ route('editProduct') }}" method="POST">
                     @csrf
                     <input type="hidden" name="idProduct" value=" {{ $product->id }}">  
                     <button type="submit" class="btn btn-primary" style="background-color: rgb(200, 0, 0); border: none; color: white;" type="button" >Modifica</button>
               </form>
            </td>
         </tr>
         @endforeach
      </tbody>
         </table>
   </div>
</div>
@endsection