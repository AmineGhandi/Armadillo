<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateurs;


class printController extends Controller
{
    function index(){
        $data = ['LoggedUserInfo' =>Utilisateurs::where('id','=',session('LoggedUser'))->first() ];
        return view('printing.print', $data);
    }
}
