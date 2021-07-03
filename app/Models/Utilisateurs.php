<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class Utilisateurs extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mdp',
        'img'
    ];


    public function roletype(){
        if ($this->role == "Admin") {
            return "Admin";
        }
        elseif ($this->role == "Supervisor"){
            return "Supervisor";
        }
        elseif($this->role == "Print"){
            return "Print";
        }
        elseif ($this->role == "Mail") {
            return "Mail";
        }
    }
}
