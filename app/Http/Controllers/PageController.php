<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function register_form()
    {
        return view('auth_client.register');
    }

    public function login_form()
    {
        return view('auth_client.login');
    }

    public function showHome(){
        return view('layoutsAdmin/app');
    }
    
    public function register_form_admin()
    {
        return view('auth_recruteur.register');
    }

    public function login_form_employee()
    {
        return view('auth_recruteur.login');
    }

    // public function formulaire()
    // {
    //     return view('Formulaire.insertion_candidat');
    // }

    public function candidat_liste()
    {
        return view('Liste.candidat');
    }

    // public function cv_liste(){
    //     return view('Affichage.list_cv');
    // }

    public function showUpload(){
        return view('Affichage.test');
    }

    public function showCV(){
        return view('CvForm.CvForm');
    }

    public function showEmail(){
        return view('Affichage.mail');
    }

    public function test(){
        return view('ClientAffichage.Accueil');
    }

}