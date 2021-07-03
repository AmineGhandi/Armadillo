<?php

namespace App\Http\Controllers;

use App\Models\Utilisateurs;
use Hamcrest\Util;
use Illuminate\Http\Request;

class UtilisateursController extends Controller
{
    public function index(){
        return view('admin.admin-dashboard');
    }
    public function login(){
        return view('auth.login');
    }
    public function check(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'mdp'=> 'required|min:8|max:55'
        ],
        [
            'email.required' => 'veuillez remplire de le champ email',
            'email.email' => 'format incorrect',
            'mdp.required' => 'veuillez remplire de champ du mot de passe',
            'mdp.min' => 'le mot de passe ne doit etre superieur a 8 caracteres',
        ]
    ); 
    $userinfo = Utilisateurs::where('email','=',$request->email)->first();
    if (!$userinfo) {
        return back()->with('fail','email incorrect');
    }
    else{
        if ($request->mdp == $userinfo->mdp) {
            $request->session()->put('LoggedUser', $userinfo->id);
            if ($userinfo->roletype()== "Admin") {
                return redirect()->route('Admin');
            }elseif ($userinfo->roletype()== "Supervisor") {
                return redirect()->route('Supervisor');
            }elseif ($userinfo->roletype()== "Print") {
                return redirect()->route('Print');
            }elseif ($userinfo->roletype()== "Mail") {
                return redirect()->route('Mail');
            }
        }else{
            return back()->with('fail','mot de passe incorrect');
        }
    }
    }
    public function Adminp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $utilisateurs = Utilisateurs::all();
        return view('Admin.admin-dashboard', $data, compact('utilisateurs'));
    }
    public function Printp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('print.printdashboard', $data);
    }
    public function Mailp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('mail.maildashboard', $data);
    }
    public function logout(){
        if (session()->has('LoggedUser')) {
            session()->pull('LoggedUser');
            return redirect('/login');
        }
    }
    public function editprofil($id){
        $User = Utilisateurs::find($id);
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('admin.edit-profil', $data , compact('User'));
    }
    public function updateUser($id , Request $request){
        $user = Utilisateurs::find($id);
        

        

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->mdp = $request->mdp;
        if($request->hasFile('img')){
        $user_img = $request->file('img');
        $name_gen = hexdec(uniqid());
        $image_ext = strtolower($user_img->getClientOriginalExtension());
        $image_name = $name_gen . '.' . $image_ext;
        $up_location = 'image/utilisateurs/';
        $last_img = $up_location . $image_name ;
        $user_img->move($up_location,$image_name);
        $user->img = $last_img;

        }
             
        
        

        $user->save();

        return redirect(route('Admin'))->with('success','Informations modifiées avec succès!');
        
    }
}
