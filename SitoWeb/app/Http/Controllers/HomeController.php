<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Http\Controllers\EmailController;

/**
 * Questa classe si occupa di gestire il caricamento della pagina home del sito.
 */
class HomeController extends Controller{
	
    /**
     * Create a new controller instance.
     */
    public function __construct(){
        $this->middleware('auth');
    }

	/**
	 * Metodo index: Mostra la pagina principale dell'utente.
	 * Il metodo recupera l'ID dell'utente autenticato e ottiene le partecipazioni associate.
	 * Se l'utente non ha partecipazioni, recupera tutti i gruppi con le relative partecipazioni e mostra la vista 'group.list'.
	 * Altrimenti, recupera l'ID del primo gruppo delle partecipazioni, ottiene i prodotti del gruppo con le informazioni aggiuntive
	 * come la quantità dell'utente nel carrello e mostra la vista 'homeUtente' con le informazioni del gruppo e i prodotti.
	 *  @return ritororna la pagina da caricare.
	 */
    public function index(){
		
		$error= "";
		$saved= "";
        $result = (new EmailController)->index();
        $participations = DB::table('groups')
            ->join('participations', 'groups.id', '=', 'participations.idGroup')
            ->select( '*' )
            ->where('participations.idUser',Auth::user()->id)
            ->orderBy('groups.name')
            ->get();

        if ($participations->isEmpty()) {
            $groups = $this->getGroupsWithParticipations(Auth::user()->id);
            return view('group.list', ['groups' => $groups]);
        } else {
            $groupID = $participations[0]->idGroup;
            $products = $this->getGroupProducts($groupID);

            return view('/homeUtente', ['groupInfo' => $participations, 'products' => $products,'error'=>$error,'saved'=>$saved]);
        }
        
    }

    /**
     *  Metodo getGroupsWithParticipations: Recupera tutti i gruppi con le relative partecipazioni per l'utente specificato.
     * Il metodo esegue una query per ottenere i gruppi a cui l'utente partecipa, inclusi quelli senza partecipazioni.
     * @param int $userID ID dell'utente
     */
    private function getGroupsWithParticipations($userID){

        return Group::leftJoin('participations', function ($join) use ($userID) {
            $join->on('groups.id', '=', 'participations.idGroup')
                ->where('participations.idUser', '=', $userID);
        })
        ->select('groups.*', DB::raw('IFNULL(COALESCE(participations.request, "dont\'set"), "dont\'set") as request'))
		->orderBy('groups.name')
        ->get();        
    }

    /**
     * Metodo getGroupProducts: Recupera i prodotti del gruppo specificato per l'utente autenticato.
     * Il metodo esegue una query per ottenere i prodotti di un gruppo, inclusi informazioni aggiuntive come la quantità dell'utente nel carrello.
     * @param int $groupID ID del gruppo
     */
    private function getGroupProducts($groupID){
        $products = DB::table('products')
        ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.quantityMin', 'products.multiple', DB::raw('IFNULL(carts.quantity, 0) AS userQuantity'), 'products.idGroup','products.image')
        ->join('groups', 'products.idGroup', '=', 'groups.id')
        ->join('participations', 'groups.id', '=', 'participations.idGroup')
        ->join('users', 'participations.idUser', '=', 'users.id')
        ->leftJoin('carts', function ($join) {
            $join->on('products.id', '=', 'carts.idProduct')
                ->where('carts.idUser', '=', Auth::user()->id);
        })
        ->where('users.id', Auth::user()->id)
        ->where('products.idGroup', $groupID)
        ->where('products.visible', 0)
        ->orderBy('products.name')
        ->get();
        return $products;
    }
}
