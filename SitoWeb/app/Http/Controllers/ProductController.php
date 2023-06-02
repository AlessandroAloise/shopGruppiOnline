<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\Cart;
use App\Models\Participation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

/**
 * Classe che si occupa della gestione dei prodotti dalla creazione alla modifica.
 */
class ProductController extends Controller{
    /**
     * Mostra la vista per aggiungere un prodotto al gruppo.
     *
     * @param  Request  $request La richiesta ricevuto dalla pagina
     * @return view La view di manager
     */
    public function add(Request $request){
        $groupId = $request->groupId;
        return view('group.addProduct', ['groupId' => $groupId]);
    }

    /**
     * Aggiunge un nuovo prodotto al gruppo.
     *
     * @param  Request  $request La richiesta ricevuto dalla pagina
     * @return view La view di manager
     */
    public function addRequest(Request $request){

        $groupId = $request->groupId;
        $currency= str_replace("'", "",substr($request->currency, 0, -3));
        if( $request->action == 1){
            Product::create([
                'code' => $request->codice,
                'name' => $request->nome,
                'description' => $request->description,
                'price' => $currency,
                'quantityMin' => $request->minimumQuantity,
                'image'=> base64_encode(file_get_contents($request->file('image')->getRealPath())),
                'multiple' => $request->quantityMultiple,
                'idGroup' => $groupId,
                'visible' => 0,
            ]);
        } 
        
        $products = $this->getGroupProducts($groupId);
        $groupInfo = $this->getGroupInfo($groupId);

        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }

    /**
     * Permette di modificare il prodotto.
     *
     * @param  Request  $request La richiesta ricevuto dalla pagina
     * @return view La view di modifica prodotto
     */
    public function editProduct(Request $request){
        $product = DB::table('products')
        ->select('*')
        ->where('id', $request->idProduct)  
        ->get();

        return view('group.editProduct', ['product' => $product]);
    }

    /**
     * Salva le modifiche di un prodotto.
     *
     * @param  Request  $request  La richiesta che contenente i dati del prodotto da modificare
     * @return view La vista contenente i prodotti aggiornati e le informazioni sul gruppo
     */
    public function saveEditProduct(Request $request){
        $currency= str_replace("'", "",substr($request->currency, 0, -3));
        if($request->action == 1){
            DB::table('products')
            ->where('id', $request->idProduct)
            ->update(
                ['code' => $request->codice,
                'name' => $request->nome,
                'description' => $request->description,
                'price' => $currency,
                'quantityMin' => $request->minimumQuantity,
                'multiple' => $request->quantityMultiple,]);

        }
        $groupId= DB::table('products')
        ->select('idGroup')
        ->where('id', $request->idProduct)
        ->get();
        $groupId= $groupId[0]->idGroup;
        $products =DB::table('products')
        ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.quantityMin', 'products.multiple', DB::raw('IFNULL(carts.quantity, 0) AS userQuantity'), 'products.idGroup', 'products.image', 'products.visible',DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'), 'products.code')
        ->join('groups', 'products.idGroup', '=', 'groups.id')
        ->join('participations', 'groups.id', '=', 'participations.idGroup')
        ->join('users', 'participations.idUser', '=', 'users.id')
        ->leftJoin('carts', function ($join) {
            $join->on('products.id', '=', 'carts.idProduct')
                ->where('carts.idUser', '=', Auth::user()->id);
        })
        ->where('users.id', Auth::user()->id)
        ->where('products.idGroup', $groupId)
        ->orderBy('products.name', 'ASC')
        ->get();
        $groupInfo = $this->getGroupInfo($groupId);


        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }

    /**
     * Inverte lo stato di visibilità del prodotto.
     *
     * @param  Request  $request  La richiesta che contenente i dati del prodotto da modificare
     * @return view La vista di manager
     */
    public function visibleProduct(Request $request){
        $groupId = $request->groupId;
        $productId = $request->idProduct;

        DB::table('products')
            ->where('id', $productId)
            ->update(['visible' => DB::raw('NOT visible')]);

        $products = DB::table('products')
        ->select('products.*', DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'))
        ->where('idGroup',  $groupId)
        ->orderBy('name')   
        ->get();

        $groupInfo = $this->getGroupInfo($groupId);

        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }

    /**
     * Mostra la pagina di gestione dei prodotti del gruppo.
     *
     * @param  Request  $request  La richiesta con id del gruppo
     * @return view La vista di manager
     */
    public function pageManagerProduct(Request $request){
        $groupId = $request->groupId;
        $products = DB::table('products')
        ->select('products.*', DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'))
        ->where('idGroup', $groupId )
        ->orderBy('name')   
        ->get();
        $groupInfo = $this->getGroupInfo($groupId);


        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }

    /**
     * Mostra la pagina di ordine dei prodotti del gruppo.
     *
     * @param  Request  $request  La richiesta con id del gruppo
     * @return view La home del sito
     */
    public function order(Request $request){
        $error= "";
        $saved = "";
        $groupId = $request->groupId;
        $products = $this->getGroupProducts($groupId);
        $groupInfo = $this->getGroupInfo($groupId);

        return view('homeUtente', ['products' => $products, 'groupInfo' => $groupInfo,'error'=>$error, 'saved'=>$saved]);
    }


    /**
     * Salva l'ordine del prodotto per l'utente corrente.
     *
     * @param  Request  $request  La richiesta con id del prodotto e la quantità
     * @return view La vista di home del sito
     */
    public function saveOrder(Request $request){
        $error= "";
        $saved="";
        $idUser = Auth::user()->id;
        $idProduct = $request->product_id;
        $quantity = $request->quantiy;

        $controlProduct = DB::table('carts')
            ->where('idUser', $idUser)
            ->where('idProduct', $idProduct)
            ->get();

        $controlMultiple = DB::table('products')
            ->where('id', $idProduct)
            ->get();

        $groupId = $request->group_id;
        $groupInfo = $this->getGroupInfo($groupId);

        if ($quantity == 0 || ($quantity >= $controlMultiple[0]->quantityMin && ($quantity % $controlMultiple[0]->multiple == 0) && $controlMultiple[0]->visible == 0)) {
            if ($controlProduct->isEmpty()) {
                Cart::create([
                    'idUser' => $idUser,
                    'idProduct' => $idProduct,
                    'quantity' => $quantity,
                ]);
            }else{
                DB::table('carts')
                    ->where('idUser', $idUser)
                    ->where('idProduct', $idProduct)
                    ->update(['quantity' => $quantity]);
            }
            $saved= "Campo salvato";
        }else{
            $error = "Campo non salvato quantità non valida";

        }
         $products = $this->getGroupProducts($groupId);
        return view('homeUtente', ['products' => $products ,'groupInfo' => $groupInfo,'error'=>$error,'saved'=>$saved ]);
    }

    /**
     * Recupera i prodotti del gruppo specificato.
     *
     * @param  int  $groupId  ID del gruppo
     */
    private function getGroupProducts($groupId){
        return DB::table('products')
            ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.quantityMin', 'products.multiple', DB::raw('IFNULL(carts.quantity, 0) AS userQuantity'), 'products.idGroup', 'products.image', 'products.visible',DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'), 'products.code')
            ->join('groups', 'products.idGroup', '=', 'groups.id')
            ->join('participations', 'groups.id', '=', 'participations.idGroup')
            ->join('users', 'participations.idUser', '=', 'users.id')
            ->leftJoin('carts', function ($join) {
                $join->on('products.id', '=', 'carts.idProduct')
                    ->where('carts.idUser', '=', Auth::user()->id);
            })
            ->where('users.id', Auth::user()->id)
            ->where('products.idGroup', $groupId)
			->where('products.visible', 0)
            ->orderBy('products.name', 'ASC')
            ->get();
    }


    /**
     * Recupera le informazioni del gruppo specificato.
     *
     * @param  int  $groupId  ID del gruppo
     */
    private function getGroupInfo($groupId){
        return DB::table('groups')
            ->where('id', $groupId)
            ->get();
    }

}