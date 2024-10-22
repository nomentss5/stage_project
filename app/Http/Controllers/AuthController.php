<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Notification;
use App\Models\Notification_recruteur;



class AuthController extends Controller
{
    public function loginAction(Request $request){
        Validator::make($request->all(), [
            'identifier' => 'required',
            'password' => 'required',
        ],[
            'identifier.required' => 'L\'identifiant est requis.',
            'password.required' => 'mot de passe est requis.',

        ])-> validate();

         // entre dans if si authentification echoue
            // verifie colonne email et colonne password dans base de donnee
            if (!Auth::attempt($request->only('identifier', 'password'), $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                'connexion' => trans('Identifiant ou mot de passe non valide')
                ]);
            }

            $user = Auth::user();

        if ($user->level == 0) {
            // Recruteurs
            return redirect()->route('showCandidats');
        } elseif ($user->level == 1) {
            // Client
            return redirect()->route('client.Home');
        }

        // Gestion d'autres niveaux d'accès si nécessaire

        throw ValidationException::withMessages([
            'identifier' => trans('auth.failed')
        ]);
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function register_Admin(Request $request){
        Validator::make($request->all(), [
            'name' => 'required',
            'identifier' => 'required',
            'password' => 'required',
            'confirmation' => 'required|same:password',
        ],[
            'name.required' => 'Le nom est requis.',
            'identifier.required' => 'L\'adresse e-mail ou identifiant est requise.',
            // 'email.email' => 'L\'adresse e-mail doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'confirmation.required' => 'La confirmation du mot de passe est requise.',
            'confirmation.same' => 'La confirmation du mot de passe ne correspond pas.',

        ])-> validate();
        
  
        User::create([
            'name' => $request->name,
            'identifier' => $request->identifier,
            'level' => 0,
            'password' => Hash::make($request->password),
        ]);
  
        return redirect()->route('showLogin_employee');
    }

    public function register_client(Request $request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,identifier',
            'password' => 'required',
            'confirm' => 'required|same:password',
        ],[
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.unique' => 'L\'adresse e-mail déja prise.',
            'email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'password.required' => 'Le mot de passe est requis.',
            'confirm.required' => 'La confirmation du mot de passe est requise.',
            'confirm.same' => 'La confirmation du mot de passe ne correspond pas.',
        ])-> validate();
  
        $user = User::create([
            'name' => $request->name,
            'identifier' => $request->email,
            'level' => 1,
            'password' => Hash::make($request->password),
        ]);

        // $notification = Notification::create([
        //     'id_user' => $user->id,
        //     'type' => 0,
        // ]);

        $id_user= $user->id;
        $type = 0;

        $this->notification_create($id_user, $type);  // inserer notification dans la table notification et notification_recruteur

        return redirect()->route('showLogin');
    }


    // inserer notification dans la table notification et notification_recruteur
    // avoir deux parametre l'id du candidat $id_user et le type de notification $type 0 pour notif nouveau candidat et 1 pour notif completion d'entretient
    public function notification_create($id_user, $type){
        $notification = Notification::create([
            'id_user' => $id_user,
            'type' => $type,
        ]);


        $users = User::where('level', 0)
        ->get();

        foreach ($users as $user) {

            $notification_recruteur = Notification_recruteur::create([
                'id_recruteur' => $user->id,
                'id_notification' => $notification->id,
                // 'is_read' => false,
                // 'is_deleted' => false,
            ]);
        }
    }
}