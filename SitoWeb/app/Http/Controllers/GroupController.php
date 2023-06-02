<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\Participation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/*
 * Questa classe si occupa di tutta la gestione dei gruppi dalla creazione alla modifica.
 */
class GroupController extends Controller{

    /**
     * Mostra la vista per iniziare la creazione di un nuovo gruppo.
     * @return view ritororna la pagina da caricare.
     */
    public function start(){
        return view('group.create');
    }

    /**
     * Crea un nuovo gruppo utilizzando i dati forniti nella richiesta.
     * @param Request $request La richiesta HTTP ricevuta.
     * @return view ritororna la pagina da caricare.
     */
    public function create(Request $request){
        $this->validate($request, [
            'nameGroup' => 'required|string',
        ]);

        $userID = Auth::user()->id;
        $groupName = $request->nameGroup;
        
        $existingGroup =  Group::where('name', $groupName)->first();
        if ($existingGroup) {
            return redirect()->back()->withErrors(['nameGroup' => 'Il nome del gruppo è già stato utilizzato.']);
        }
    
        $group = $this->createGroup($request, $userID);
        $participation = $this->createParticipation($userID, $group->id);
        $groups = $this->getGroupsWithParticipations($userID);
        return view('group.list', ['groups' => $groups]);
    }
    

    /**
     * Gestisce le modifiche al gruppo effettuate dal manager.
     * @param Request $request La richiesta HTTP ricevuta.
     * @return view ritororna la pagina da caricare.
     */
    public function managerChanges(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'deadline1' => 'required|date',
            'deadline2' => 'required|date',
        ]);
        $groupInfo = $this->getGroupInfo($request->groupId);
        $products = $this->getGroupProducts($groupInfo[0]->id);
        
        if ($request->action == 1) {
            $existingGroup = Group::where('name', $request->name)->first();
            if ($existingGroup && $request->oldName != $request->name) {
            } else {
                $deadline1 = Carbon::parse($request->deadline1);
                $deadline2 = Carbon::parse($request->deadline2);
                
                if ($deadline1->greaterThanOrEqualTo(Carbon::now())) {
                    if ($deadline2->greaterThan($deadline1->addDay())) {
                        Group::where('id', $request->groupId)->update([
                            'name' => $request->name,
                            'deadline1' => $request->deadline1,
                            'deadline2' => $request->deadline2,
                        ]);
                    } else {
                    }
                } else {
                }
            }
        }
        $groupInfo = $this->getGroupInfo($request->groupId);
        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }


    /**
     * Mostra le informazioni del gruppo specificato.
     * @param Request $request La richiesta HTTP ricevuta.
     * @return view ritororna la pagina da caricare.
     */
    public function info(Request $request){
        $this->validate($request, [
            'groupId' => 'required|integer',
        ]);

        $groups = $request->groupId;
        $groupInfo = $this->getGroupInfo($groups);
        $participationsCount = $this->countParticipations($groups, 1);
        $participationsRequestCount = $this->countParticipations($groups, 0);
        return view('group.changeInfo', ['groupInfo' => $groupInfo,'participationsCount' => $participationsCount,
            'participationsRequestCount' => $participationsRequestCount ]);
    }

    /**
     * Mostra la pagina per cambiare il gruppo corrente dell'utente.
     * @return view ritororna la pagina da caricare.
     */
    public function change(){
        $userID = Auth::user()->id;
        $groups = $this->getActiveParticipatingGroups($userID); 
        return view('group.change', ['groups' => $groups]);
    }

    /**
     * Crea un nuovo gruppo utilizzando i dati forniti nella richiesta e l'ID dell'utente.
     * @param \Illuminate\Http\Request $request La richiesta HTTP contenente i dati del gruppo.
     * @param int $userID L'ID dell'utente che sta creando il gruppo.
     * @return Group Il gruppo appena creato.
     */
    private function createGroup(Request $request, $userID){
        $this->validate($request, [
            'nameGroup' => 'required|string',
            'deadline1' => 'required|date',
            'deadline2' => 'required|date',
        ]);

        return Group::create([
            'name' => $request->nameGroup,
            'deadline1' => $request->deadline1,
            'deadline2' => $request->deadline2,
            'idGroupLeader' => $userID,
        ]);
    }

    /**
     * Crea una nuova partecipazione associata a un utente e a un gruppo specificati.
     * @param int $userID L'ID dell'utente che partecipa.
     * @param int $groupID L'ID del gruppo a cui si partecipa.
     * @return Participation La partecipazione appena creata.
     */
    private function createParticipation($userID, $groupID){
        return Participation::create([
            'request' => 1,
            'idUser' => $userID,
            'idGroup' => $groupID,
        ]);
    }

    /**
     * Ottiene tutti i gruppi con le relative partecipazioni associate a un utente specificato.
     * @param int $userID L'ID dell'utente di cui si vogliono ottenere i gruppi con partecipazioni.
     * @return Group ritororna la pagina da caricare.
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
     * Ottiene le informazioni di un gruppo specificato dall'ID del gruppo.
     * @param int $groupID L'ID del gruppo di cui si vogliono ottenere le informazioni.
     * @return Group Una collezione di oggetti Group che corrispondono all'ID specificato.
     */
    private function getGroupInfo($groupID){
        return Group::where('id', $groupID)->get();
    }
    

   /**
    * Ottiene i prodotti associati a un gruppo specificato dall'ID del gruppo.
    * @param int $groupID L'ID del gruppo di cui si vogliono ottenere i prodotti.
    * @return ritorna i prodotti.
    */
    private function getGroupProducts($groupID){
        $products = DB::table('products')
        ->select('products.*', DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'))
        ->where('idGroup', $groupID)
        ->orderBy('name')   
        ->get();
        return  $products;
    }
    
    /**
     * Conta il numero di partecipazioni per un gruppo specificato dall'ID del gruppo e dalla richiesta.
     * @param int $groupID L'ID del gruppo di cui si vuole contare le partecipazioni.
     * @param int $request La richiesta delle partecipazioni da contare (1 per partecipazioni accettate, 0 per richieste pendenti).
     * @return int Il numero di partecipazioni corrispondenti ai criteri specificati.
     */
    private function countParticipations($groupID, $request){
        return Participation::where('idGroup', $groupID)
        ->where('request', $request)
        ->count();
    }

    /**
     * Ottiene i gruppi attivi in cui l'utente partecipa.
     * @param int $userID L'ID dell'utente di cui si vogliono ottenere i gruppi attivi.
     * @return ritororna la pagina da caricare.
     */
    private function getActiveParticipatingGroups($userID){
        return Group::join('participations', 'groups.id', '=', 'participations.idGroup')
        ->where('participations.request', 1)
        ->where('participations.idUser', $userID)
        ->orderBy('groups.name')
        ->get();
    }


    /**
     * Approva un prodotto all'interno di un gruppo.
     *
     * @param  Request  $request  La richiesta HTTP contenente l'ID del gruppo
     * @return view  La vista contenente i prodotti aggiornati e le informazioni sul gruppo
     */
    public function approveProduct(Request $request){
        $this->validate($request, [
            'groupId' => 'required|integer',
        ]);

        $groupId= $request->groupId;
        $groupInfo = $this->getGroupInfo($groupId);
        Group::where('id', $groupId)->update([
            'approved' =>1,
        ]); 
        $products = DB::table('products')
        ->select('products.*', DB::raw('(SELECT SUM(quantity) FROM carts WHERE idProduct = products.id) AS totalOrderedQuantity'))
        ->where('idGroup', $groupId )
        ->orderBy('name')   
        ->get();
        $groupInfo = $this->getGroupInfo($groupId);


        return view('group.manager', ['products' => $products, 'groupInfo' => $groupInfo]);
    }
}