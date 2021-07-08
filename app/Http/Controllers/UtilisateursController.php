<?php

namespace App\Http\Controllers;

use App\Models\Utilisateurs;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            }elseif ($userinfo->roletype()== "Superviseur") {
                return redirect()->route('Supervisor');
            }elseif ($userinfo->roletype()== "Agent impression") {
                return redirect()->route('Print');
            }elseif ($userinfo->roletype()== "Agent mailing") {
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
    public function Supervisorp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('supervisor.supervisor-dashboard', $data);
    }
    public function Printp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('print.print-dashboard', $data);
    }
    public function Mailp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('mail.mail-dashboard', $data);
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
    public function updateprofil($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veullez remplire le champ du nom',
        'prenom.required' => 'veullez remplire le champ du prenom',
        'nom.regex' => 'le nom ne doit contenir que des lettres',
        'prenom.regex' => 'le prenom ne doit contenir que des lettres',
        'nom.min' => 'le nom est très court ',
        'prenom.min' => 'le prenom est très court ',
        'email.required' => 'veuillez remplire le champ email',
        'email.regex' => 'format email incorrect',
        'mdp.required' => 'veuillez remplire de champ du mot de passe',
        'mdp.min' => 'le mot de passe ne doit etre superieur a 8 caracteres',
    ]
    );

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
    public function createUser(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('admin.create-user', $data);
    }
    public function insertUser(Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:Utilisateurs',
            'mdp'=> 'required|min:8|max:55',
            'img'=> 'required|mimes:jpeg,png,jpg|image'
        ],
    [
        'nom.required' => 'veullez remplire le champ du nom',
        'prenom.required' => 'veullez remplire le champ du prenom',
        'nom.regex' => 'le nom ne doit contenir que des lettres',
        'prenom.regex' => 'le prenom ne doit contenir que des lettres',
        'nom.min' => 'le nom est très court ',
        'prenom.min' => 'le prenom est très court ',
        'email.required' => 'veuillez remplire le champ email',
        'email.regex' => 'format email incorrect',
        'mdp.required' => 'veuillez remplire de champ du mot de passe',
        'mdp.min' => 'le mot de passe ne doit etre superieur a 8 caracteres',
        'img.required' => 'veuillez choisir une image',
        'img.mimes' => 'le fichier doit etre en format jpeg ou png ou jpg',
        'img.image' => 'vous devez choisir une image'
    ]
    );
    $utilisateur = new Utilisateurs;
    $utilisateur->nom = $request->nom;
    $utilisateur->prenom = $request->prenom;
    $utilisateur->email = $request->email;
    $utilisateur->mdp = $request->mdp;
    $utilisateur->role = $request->role;

        $user_img = $request->file('img');
        $name_gen = hexdec(uniqid());
        $image_ext = strtolower($user_img->getClientOriginalExtension());
        $image_name = $name_gen . '.' . $image_ext;
        $up_location = 'image/utilisateurs/';
        $last_img = $up_location . $image_name ;
        $user_img->move($up_location,$image_name);
    $utilisateur->img = $last_img;

    $utilisateur->save();

    return redirect()->route('Admin')->with('success','Utilisateur ajouté avec succés');

    }
    public function editUser($id){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $user = Utilisateurs::find($id);
        return view('admin.edit-user', $data , compact('user'));

    }
    public function updateUser($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veullez remplire le champ du nom',
        'prenom.required' => 'veullez remplire le champ du prenom',
        'nom.regex' => 'le nom ne doit contenir que des lettres',
        'prenom.regex' => 'le prenom ne doit contenir que des lettres',
        'nom.min' => 'le nom est très court ',
        'prenom.min' => 'le prenom est très court ',
        'email.required' => 'veuillez remplire le champ email',
        'email.regex' => 'format email incorrect',
        'mdp.required' => 'veuillez remplire de champ du mot de passe',
        'mdp.min' => 'le mot de passe ne doit etre superieur a 8 caracteres',
    ]
    );

        $user = Utilisateurs::find($id);
        

        

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->mdp = $request->mdp;
        $user->role = $request->role;
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
    public function deleteUser($id){
        $user = Utilisateurs::find($id);
        $user->delete();
        return redirect(route('Admin'))->with('deleted','Utilisateur supprimé avec succés');
    }
}
