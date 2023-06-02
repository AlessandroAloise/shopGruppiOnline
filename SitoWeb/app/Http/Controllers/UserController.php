<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;

/**
 *  Classe che gestisce i cambiamenti delle informazion dell'utente.
 */
class userController extends Controller{
    /**
     * Ottiene le informazioni dell'utente corrente.
     *
     * @param  Request  $request  La richiesta HTTP
     * @return view La vista contenente le informazioni dell'utente
     */
    public function getInfo(Request $request)
    {
        $user =DB::table('users')
        ->select('*')
        ->where('id',Auth::user()->id)
        ->get();

        return view('userInfo', ['user' => $user]);
    }


    /**
     * Salva le nuove informazioni dell'utente.
     *
     * @param  Request  $request  La richiesta HTTP contenente i dati dell'utente da aggiornare
     * @return redirect Il reindirizzamento alla pagina principale
     */
    public function saveNewInfo(Request $request){
        $user = DB::table('users')
            ->select('*')
            ->where('id', Auth::user()->id)
            ->get();

        if ($request->action == 1) {
            $existingEmails = DB::table('users')
                ->select('email')
                ->where('email', '!=', $user[0]->email)
                ->get();

            foreach ($existingEmails as $existingEmail) {
                if ($existingEmail->email == $request->email) {
                    return redirect()->back()->withErrors(['email' => 'email è già utilizzata.']);
                }
            }

            User::where('id', $user[0]->id)->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
            ]);
        }

        return redirect('/');
    }

}
