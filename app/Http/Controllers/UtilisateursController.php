<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Utilisateurs;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $utilisateurs = Utilisateurs::all();
        return view('supervisor.supervisor-dashboard', $data, compact('utilisateurs'));
    }
    public function Printp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $utilisateurs = Utilisateurs::all();
        return view('print.print-dashboard', $data, compact('utilisateurs'));
    }
    public function Mailp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $utilisateurs = Utilisateurs::all();
        return view('mail.mail-dashboard', $data, compact('utilisateurs'));
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
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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
    public function createClient(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('admin.create-client', $data);
    }
    public function insertClient(Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:Utilisateurs',
            'ville' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:75',
            'date_naiss' => 'required|date|before:-18 years',
            'tel' => 'required|regex:/[0-9]{10}/',
            'rib' => 'required|regex:/[0-9]{24}/',
            'adress' => 'required'
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
        'nom.regex' => 'le nom ne doit contenir que des lettres',
        'prenom.regex' => 'le prenom ne doit contenir que des lettres',
        'nom.min' => 'le nom est très court ',
        'prenom.min' => 'le prenom est très court ',
        'email.required' => 'veuillez remplire le champ email',
        'email.regex' => 'format email incorrect',
        'ville.required' => 'veuillez remplire le champ ville',
        'ville.regex' => 'le champ ville ne doit contenir que des lettres',
        'ville.min' => 'le champ ville est très court ',
        'date_naiss.required' => 'veuillez inserer une date de naissance',
        'date_naiss.before' => "l'age du client ne doit pas etre inferieur a 18 ans",
        'tel.required' => 'veuillez remplire le champ Numero de telephone',
        'tel.regex' => 'format incorrecte',
        'rib.required' => 'veuillez remplire le champ du RIB',
        'rib.regex' => 'format incorrecte',
        'adress.required' => 'veuillez inserer votre adresse'

    ]
    );
    $Client = new Clients;
    $Client->nom = $request->nom;
    $Client->prenom = $request->prenom;
    $Client->email = $request->email;
    $Client->tel = $request->tel;
    $Client->ville = $request->ville;
    $Client->date_naiss = $request->date_naiss;
    $Client->rib = $request->rib;
    $Client->sexe = $request->sexe;
    $Client->adress = $request->adress;


    $Client->save();

    return redirect()->route('clientList')->with('success','Client ajouté avec succés');
    }
    public function clientList(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $clients = Clients::all();
        return view('admin.list-client', $data, compact('clients') );
    }
    public function editClient($id){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $client = Clients::find($id);
        return view('admin.edit-client', $data, compact('client'));
    }
    public function updateClient(Request $request , $id){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:Utilisateurs',
            'ville' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:75',
            'date_naiss' => 'required|date|before:-18 years',
            'tel' => 'required|regex:/[0-9]{10}/',
            'rib' => 'required|regex:/[0-9]{24}/',
            'adress' => 'required'
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
        'nom.regex' => 'le nom ne doit contenir que des lettres',
        'prenom.regex' => 'le prenom ne doit contenir que des lettres',
        'nom.min' => 'le nom est très court ',
        'prenom.min' => 'le prenom est très court ',
        'email.required' => 'veuillez remplire le champ email',
        'email.regex' => 'format email incorrect',
        'ville.required' => 'veuillez remplire le champ ville',
        'ville.regex' => 'le champ ville ne doit contenir que des lettres',
        'ville.min' => 'le champ ville est très court ',
        'date_naiss.required' => 'veuillez inserer une date de naissance',
        'date_naiss.before' => "l'age du client ne doit pas etre inferieur a 18 ans",
        'tel.required' => 'veuillez remplire le champ Numero de telephone',
        'tel.regex' => 'format incorrecte',
        'rib.required' => 'veuillez remplire le champ du RIB',
        'rib.regex' => 'format incorrecte',
        'adress.required' => 'veuillez inserer votre adresse'

    ]
    );
    $client = Clients::find($id);
    $client->nom = $request->nom;
    $client->prenom = $request->prenom;
    $client->email = $request->email;
    $client->tel = $request->tel;
    $client->ville = $request->ville;
    $client->date_naiss = $request->date_naiss;
    $client->rib = $request->rib;
    $client->sexe = $request->sexe;
    $client->adress = $request->adress;


    $client->save();

    return redirect()->route('clientList')->with('success','Client modifié avec succés');

    }
    public function deleteClient($id){
        $client = Clients::find($id);
        $client->delete();
        return redirect(route('clientList'))->with('deleted','Client supprimé avec succés');
    }
    public function statp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $util = DB::table('Utilisateurs')
                ->select(
                    DB::raw('role as role'),
                    DB::raw('count(*) as number'))
                ->groupBy('role')
                ->get();
        $array[] = ['role' , 'number'];
        foreach ($util as $key => $value) {
            $array[++$key] = [$value->role , $value->number];
        }
        $ville = DB::table('Clients')
                ->select(
                    DB::raw('ville as ville'),
                    DB::raw('count(*) as number'))
                ->groupBy('ville')
                ->get();
        $arrayville[] = ['ville' , 'number'];
        foreach ($ville as $key => $value) {
            $arrayville[++$key] = [$value->ville , $value->number];
        }
        $cli = DB::table('Clients')
                ->select(
                    DB::raw('sexe as sexe'),
                    DB::raw('count(*) as number'))
                ->groupBy('sexe')
                ->get();
        $arraycli[] = ['sexe' , 'number'];
        foreach ($cli as $key => $value) {
            $arraycli[++$key] = [$value->sexe , $value->number];
        }
        return view('admin.stats',$data)->with('role',json_encode($array))
                                        ->with('ville',json_encode($arrayville))
                                        ->with('sexe',json_encode($arraycli));
    }
    public function editprofilsup($id){
        $User = Utilisateurs::find($id);
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('supervisor.edit-profil', $data , compact('User'));
    }
    public function createUsersup(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('supervisor.create-user', $data);
    }
    public function editUsersup($id){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $user = Utilisateurs::find($id);
        return view('supervisor.edit-user', $data , compact('user'));

    }
    public function insertUsersup(Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:Utilisateurs',
            'mdp'=> 'required|min:8|max:55',
            'img'=> 'required|mimes:jpeg,png,jpg|image'
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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

    return redirect()->route('Supervisor')->with('success','Utilisateur ajouté avec succés');

    }
    public function updateprofilsup($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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

        return redirect(route('Supervisor'))->with('success','Informations modifiées avec succès!');
        
    }
    public function updateUsersup($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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

        return redirect(route('Supervisor'))->with('success','Informations modifiées avec succès!');
    }
    public function clientListsup(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $clients = Clients::all();
        return view('supervisor.list-client', $data, compact('clients') );
    }
    public function statpsup(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $util = DB::table('Utilisateurs')
                ->select(
                    DB::raw('role as role'),
                    DB::raw('count(*) as number'))
                ->groupBy('role')
                ->get();
        $array[] = ['role' , 'number'];
        foreach ($util as $key => $value) {
            $array[++$key] = [$value->role , $value->number];
        }
        $ville = DB::table('Clients')
                ->select(
                    DB::raw('ville as ville'),
                    DB::raw('count(*) as number'))
                ->groupBy('ville')
                ->get();
        $arrayville[] = ['ville' , 'number'];
        foreach ($ville as $key => $value) {
            $arrayville[++$key] = [$value->ville , $value->number];
        }
        $cli = DB::table('Clients')
                ->select(
                    DB::raw('sexe as sexe'),
                    DB::raw('count(*) as number'))
                ->groupBy('sexe')
                ->get();
        $arraycli[] = ['sexe' , 'number'];
        foreach ($cli as $key => $value) {
            $arraycli[++$key] = [$value->sexe , $value->number];
        }
        return view('supervisor.stats',$data)->with('role',json_encode($array))
                                        ->with('ville',json_encode($arrayville))
                                        ->with('sexe',json_encode($arraycli));
    }

    public function editprofilagentm($id){
        $User = Utilisateurs::find($id);
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('mail.edit-profil', $data , compact('User'));
    }
    public function updateprofilagentm($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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

        return redirect(route('Mail'))->with('success','Informations modifiées avec succès!');
        
    }
    public function clientListagentm(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $clients = Clients::all();
        return view('mail.list-client', $data, compact('clients') );
    }
    public function editprofilagentp($id){
        $User = Utilisateurs::find($id);
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('print.edit-profil', $data , compact('User'));
    }
    public function updateprofilagentp($id , Request $request){
        $validatedata = $request->validate([
            'nom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z]+$/u|min:3|max:255',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mdp'=> 'required|min:8|max:55',
        ],
    [
        'nom.required' => 'veuillez remplire le champ du nom',
        'prenom.required' => 'veuillez remplire le champ du prenom',
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

        return redirect(route('Print'))->with('success','Informations modifiées avec succès!');
        
    }
    public function clientListagentp(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        $clients = Clients::all();
        return view('print.list-client', $data, compact('clients') );
    }
    
}
