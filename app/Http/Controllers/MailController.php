<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Candidat;
use App\Models\SuggestionMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class MailController extends Controller
{
    public function SendEmailAction(Request $request){

        $request->validate([
            // 'sender' => 'required|email',
            'receiver' => 'required|email',
            'message' => 'required|string',
            'subject' => 'required|string',

        ]);

        $sender = $request->input('sender');
        // dump($sender);
        $receiver = $request->input('receiver');
        // dump($receiver);
        $message =  nl2br($request->input('message'));
        // dump($message);
        $subject = $request->input('subject');

        // Envoi de l'e-mail réel

        try {
            // Envoi de l'e-mail
            Mail::to($receiver)->send(new SendMail($message, $sender, $subject));

            // Vérification si des erreurs sont survenues
            // if (Mail::failures()) {
            //     return back()->with('error', 'Impossible d\'envoyer l\'e-mail. Vérifiez que l\'adresse e-mail du destinataire est correcte.');
            // }

            return back()->with('success', 'Email envoyé verifier votre boite mail !');
        } 
        catch (\Exception $e) {
            // Autres erreurs générales
            Log::error('Erreur générale : ' . $e->getMessage());
    
            return back()->with('error', 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. ');
        }

    }

    public function Formulaire() {
        $suggestions = DB::table('suggestion_message')->get();

        return view('emails.envoyer_mail', compact('suggestions'));
    }
    

    public function get_email($id){
        // Récupérer le candidat avec l'ID spécifié
        $candidat = Candidat::where('id', $id)->first();
        $suggestions = DB::table('suggestion_message')->get();

        return view('emails.envoyer_mail', compact('candidat','suggestions'));
    }

    public function get_suggestion($id){
        // $suggestion_message = DB::table('suggestion_message')
        // ->where('id', $id)
        // ->pluck('message');

        $suggestion_message = SuggestionMessage::where('id', $id)->first();

        // dd($suggestion_message->message);

        return redirect()->back()->with('suggestion_message', $suggestion_message->message);
    }

    public function Formulaire_parametre()
    {
        return view('emails.parametre_mail');
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        $env = File::get($envPath);

        foreach ($data as $key => $value) {
            $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
        }

        File::put($envPath, $env);
    }

    // pour modifier parametre mail dans .env
    public function updateParametre(Request $request)
    {
        $test = $request->merge([
            'password' => str_replace(' ', '', $request->password),
        ]);

        Validator::make($request->all(), [
            'mail_username' => 'required|email',
            'password' => 'required',
        ],[
            'mail_username.required' => 'le mail est requis',
            'mail_username.email' => 'format incorrect du mail',
            'password.required' => 'le mot de passe est requis',

        ])-> validate();
        
        $this->updateEnv([
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->password,
        ]);

        // Recharger la configuration pour que les nouveaux paramètres prennent effet
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        return back()->with('succes', 'Mail settings updated successfully!');
    }

    public function testa(){

        return view('emails.test');
    }
}