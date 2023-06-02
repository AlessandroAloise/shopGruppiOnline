<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\Participation;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;


/**
 * Classe che si occupa della gestione delle fatture.
 */
class InvoiceController extends Controller{
    
    /**
     * Mostra la fattura per un determinato gruppo.
     *
     * @param  Request  $request  La richiesta HTTP contenente l'ID del gruppo
     * @return View  La vista contenente la fattura del gruppo
     */
    public function invoceShow(Request $request){
         $this->validate($request, [
            'groupId' => 'required|integer',
        ]);
        $users = DB::table('participations')
                ->join('users', 'participations.idUser', '=', 'users.id')
                ->join('carts', function ($join) use ($request) {
                    $join->on('participations.idUser', '=', 'carts.idUser')
                        ->where('participations.idGroup', '=', $request->groupId);
                })
                ->join('products', function ($join) use ($request) {
                    $join->on('carts.idProduct', '=', 'products.id')
                        ->where('products.idGroup', '=', $request->groupId)
                        ->where('products.visible', '=', 0);
                })
                ->where('carts.quantity', '>', 0)
                ->select('users.id', 'users.name', 'users.surname', DB::raw('SUM(products.price * carts.quantity) as totalSpent'))
                ->groupBy('users.id', 'users.name', 'users.surname')
                ->get();

        $totalValue = DB::table('users')
            ->join('carts', 'carts.idUser', '=', 'users.id')
            ->join('products', 'products.id', '=', 'carts.idProduct')
            ->join('groups', 'groups.id', '=', 'products.idGroup')
            ->where('groups.id', $request->groupId)
            ->where('products.visible', '=', 0)
            ->sum(DB::raw('products.price * carts.quantity'));

        $name =  DB::table('groups')
            ->select('*')
            ->where('id', $request->groupId)
            ->limit(1)
            ->get();

        return view('group.invoice', ['users' => $users,'totalValue'=>$totalValue, 'name'=>$name]);
    }

    /**
     * Crea un file PDF contenente la fattura per un determinato gruppo.
     *
     * @param  Request  $request  La richiesta HTTP contenente l'ID del gruppo e l'ID dell'utente
     */
    public function createPDF(Request $request){   
        $nameGroup=$request->nameGroup;
        $idUser=$request->idUser;
        $cartProducts = DB::table('users')
            ->join('carts', 'users.id', '=', 'carts.idUser')
            ->join('products', 'carts.idProduct', '=', 'products.id')
            ->join('groups', 'products.idGroup', '=', 'groups.id')
            ->select('products.name', 'carts.quantity', 'products.price','products.code', DB::raw('products.price * carts.quantity AS totalPrice'), 'groups.name AS group_name')
            ->where('users.id', $idUser)
            ->where('carts.quantity','>', 0)
            ->where('products.visible', 0) 
            ->where('groups.name',$nameGroup)
            ->groupBy('products.name', 'carts.quantity', 'products.price', 'groups.name', 'products.code')
            ->get();
        $user = DB::table('users')
            ->select('name', 'surname', 'email')
            ->where('id', $idUser)
            ->get();

        $totalValue = DB::table('users')
            ->join('carts', 'carts.idUser', '=', 'users.id')
            ->join('products', 'products.id', '=', 'carts.idProduct')
            ->join('groups', 'groups.id', '=', 'products.idGroup')
            ->where('users.id',  $idUser)
            ->where('products.visible', 0) 
            ->where('groups.name',$nameGroup)
            ->sum(DB::raw('products.price * carts.quantity'));

        $capoGruppo = DB::table('users')
            ->join('groups', 'users.id', '=', 'groups.idGroupLeader')
            ->select('users.name', 'users.surname', 'users.email')
            ->where('groups.name', $nameGroup)
            ->first();

        //Creazione del pdf
        $dompdf = new Dompdf( );
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->load_html( view('group.invioceBase', ['nameGroup'=>$nameGroup,'cartProducts'=>$cartProducts, 'user'=>$user, 'capoGruppo'=>$capoGruppo, 'totalValue'=>$totalValue]) );
        $dompdf->render( );
        $dompdf->stream('Fattura_' . $nameGroup . "_". $user[0]->name . "_". $user[0]->surname .'.pdf');

    }

}
