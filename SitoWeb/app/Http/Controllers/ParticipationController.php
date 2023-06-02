<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\User;
use App\Models\Cart;
use App\Models\Participation;
use Illuminate\Support\Facades\DB;
/*
 * Questa classe si occupa di gestire tutte le operazioni inrerenti alla partecipazione a un gruppo.
 */
class ParticipationController extends Controller{
    
    /**
     * Mostra l'elenco dei gruppi con le relative partecipazioni.
     * Il metodo recupera l'ID dell'utente autenticato e ottiene i gruppi con le partecipazioni associate.
     * Mostra la vista 'group.list' con l'elenco dei gruppi.
     * @return ritororna la pagina da caricare.
     */
    public function list(){
        $userID = Auth::user()->id;

        $groups = $this->getGroupsWithParticipations($userID);

        return view('group.list', ['groups' => $groups]);
    }

    /**
     * Invia una richiesta di accesso per un gruppo.
     * Il metodo valida l'ID del gruppo fornito nella richiesta.
     * Verifica se l'utente ha già inviato una richiesta per lo stesso gruppo.
     * Se non ha ancora inviato una richiesta, crea una nuova partecipazione con lo stato di richiesta in sospeso.
     * Infine, ottiene nuovamente i gruppi con le partecipazioni associate e mostra la vista 'group.list'.
     * @param  Request  $request  Oggetto della richiesta HTTP
     * @return ritororna la pagina da caricare.
     */
    public function requestAccessSend(Request $request){
        $request->validate([
            'groupId' => 'required'
        ]);

        $userID = Auth::user()->id;

        $controlRequest = Participation::where('idUser', $userID)
            ->where('idGroup', $request->groupId)
            ->get();

        if ($controlRequest->isEmpty()) {
            Participation::create([
                'request' => 0,
                'idUser' => $userID,
                'idGroup' => $request->input('groupId'),
            ]);
        }

        $groups = $this->getGroupsWithParticipations($userID);

        return view('group.list', ['groups' => $groups]);
    }

    /**
     * Mostra la pagina delle richieste di accesso per un gruppo specificato.
     * Il metodo recupera le richieste di accesso in sospeso per il gruppo specificato.
     * Mostra la vista 'group.request' con l'elenco delle richieste di accesso.
     * @return ritororna la pagina da caricare.
     */
    public function requestAccessPage(Group $group ){
        $accessRequests = User::join('participations', 'participations.idUser', '=', 'users.id')
            ->where('participations.idGroup', $group->id)
            ->where('participations.request', 0)
            ->get();
        return view('group.request', ['accessRequests' => $accessRequests,'group'=>$group]);
    }

    /**
     * Recupera tutti i gruppi con le relative partecipazioni per l'utente specificato.
     * Il metodo esegue una query per ottenere i gruppi a cui l'utente partecipa, inclusi quelli senza partecipazioni.
     * @param  int  $userID  ID dell'utente
     * @return ritororna la pagina da caricare.
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
     * Metodo che si occupa di accettare o rifutare le richieste di accesso.
     *  @return ritorna la pagina da caricare.
     */
    public function setParticipations(Request $request){
        if($request->action == 1){
            DB::table('participations')
            ->where('idUser', $request->idUser)
            ->where('idGroup', $request->idGroup)
            ->update(['request' => 1 ]);

        }else{
            DB::table('participations')
            ->where('idUser', $request->idUser)
            ->where('idGroup', $request->idGroup)
            ->delete();

        }
        $accessRequests = Participation::where('idGroup', $request->idGroup)
            ->where('request', 0)
            ->get();
        
        return view('group.request', ['accessRequests' => $accessRequests]);
    }


    /**
     * Mostra la lista dei partecipanti per un determinato gruppo.
     *
     * @param  Group  $group  Il gruppo per cui visualizzare la lista dei partecipanti
     * @return La vista contenente la lista dei partecipanti
     */
    public function listParticipants(Group $group){
        
        $list = User::join('participations', 'participations.idUser', '=', 'users.id')
            ->where('participations.idGroup', $group->id)
            ->where('participations.request', 1)
            ->get();
        return view('group.listParticipants', ['list' => $list,'group'=>$group]);

    }

    /**
     * Blocca un utente all'interno di un gruppo.
     *
     * @param  Request  $request  La richiesta che contenente i dati dell'utente e del gruppo
     */
    public function block(Request $request){
        $userId =  $request->idUser; 
        $groupId =  $request->idGroup; 
        
        Cart::whereHas('users', function ($query) use ($groupId, $userId) {
                $query->where('idGroup', $groupId)
                      ->where('id', $userId);
            })
            ->delete();
    
        DB::table('participations')
        ->where('idUser', $request->idUser)
        ->where('idGroup', $request->idGroup)
        ->delete();

    }
}