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
        elseif ($this->role == "Superviseur"){
            return "Superviseur";
        }
        elseif($this->role == "Agent impression"){
            return "Agent impression";
        }
        elseif ($this->role == "Agent mailing") {
            return "Agent mailing";
        }
    }
}
