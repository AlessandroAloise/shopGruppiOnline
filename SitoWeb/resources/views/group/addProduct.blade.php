@extends('layouts.app')

@section('content')

<div style="display: flex; flex-direction: row; height: 100%;">

    <div style="flex: 1; padding: 20px;">
    <h1> Aggiungi Prodotto </h1>
        <form action="{{ route('addProductRequest') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome"  style="width: 100%; padding: 5px;" required placeholder="Nome prodotto" maxlength="255">
                <input type="hidden" name="groupId" value=" {{$groupId}}" >
            </div>

            <div style="margin-bottom: 20px;">
                <label for="codice">Codice:</label>
                <input type="text" id="codice" name="codice" style="width: 100%; padding: 5px;"  maxlength="255">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="prezzo">Prezzo:</label>
                <input style="width: 100%; padding: 5px;" ; type="text" name="currency" id="prezzo"  value="" data-type="currency"  required placeholder="10.00 CHF" max="2147483647">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="minimumQuantity">Quantità minima:</label>
                <input type="number" id="minimumQuantity" name="minimumQuantity" style="width: 100%; padding: 5px;"  required value="1"; max="2147483647">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="quantityMultiple">Multiplo:</label>
                <input type="number" id="quantityMultiple" name="quantityMultiple" style="width: 100%; padding: 5px; " required value="1"; max="2147483647">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="description">Descrizione:</label>
                <input type="text" id="description" name="description" style="width: 100%; padding: 5px; "  maxlength="255" required placeholder="Scrivi la descrtizione del prodotto";>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="immagine">Immagine:</label>
                <input type="file" required name="image">
            </div>
            <button type="submit" name="action" value="0" style="background-color: rgb(255, 0, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Annulla</button>
            <button type="submit" name="action" value="1" style="background-color: rgb(0, 204, 0); border: none; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer;">Aggiungi</button>
        </form>
    </div>

</div>
<script>
	$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 100'000
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "'")
}


function formatCurrency(input, blur) {
  var currency= " CHF";
  var input_val = input.val();

  if (input_val === "") { return; }

    var original_len = input_val.length;
    var caret_pos = input.prop("selectionStart");
    
  if (input_val.indexOf(".") >= 0) {
    var decimal_pos = input_val.indexOf(".");

    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    left_side = formatNumber(left_side);
    right_side = formatNumber(right_side);
    
    if (blur === "blur") {
      right_side += "00";
    }

    right_side = right_side.substring(0, 2);
    input_val =  left_side + "." + right_side + currency;

  } else {

    input_val = formatNumber(input_val);
    input_val =  input_val;

    if (blur === "blur") {
      input_val += ".00" + currency;
    }
  }
  input.val(input_val);
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}



</script>	
@endsection