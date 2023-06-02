<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

/*
 * Questa classe si occupa di gestire le Email.
 */
class EmailController extends Controller{    
    
    /**
     * Gestisce l'invio delle email agli utenti dei gruppi in base alle scadenze.
     *
     */
    public function index(){
        $currentDate = date("Y-m-d");
        $emailData = [
            [
                'deadlineColumn' => 'deadline1',
                'sendEmailColumn' => 'sendEmail1',
                'emailSubject' => 'Termine 1 scaduto'
            ],
            [
                'deadlineColumn' => 'deadline2',
                'sendEmailColumn' => 'sendEmail2',
                'emailSubject' => 'Termine 2 scaduto'
            ]
        ];

        foreach ($emailData as $data) {
            $emails = DB::table('users')
                ->join('groups', 'groups.idGroupLeader', '=', 'users.id')
                ->where($data['deadlineColumn'], '<', $currentDate)
                ->where($data['sendEmailColumn'], '=', null)
                ->select('users.email', 'groups.name', $data['sendEmailColumn'])
                ->get();

            foreach ($emails as $email) {
                $testMailData = [
                    'title' => 'Gruppo ' . $email->name,
                    'body' => $data['emailSubject']
                ];

                Mail::to($email->email)->send(new SendMail($testMailData));

                Group::where('name', $email->name)->update([
                    $data['sendEmailColumn'] => 1
                ]);
            }
        }
    }
}