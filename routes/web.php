<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\MultiMailController;
use App\Http\Controllers\printController;
use App\Http\Controllers\printerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::post('/check',[UtilisateursController::class,'check'])->name('check');
Route::get('/logout',[UtilisateursController::class,'logout'])->name('logout');
Route::get('/login',[UtilisateursController::class ,'login'])->name('login');

Route::group(['middleware'=>['AuthCheck']],function(){
    //Routes Depending on role
    Route::get('/admin-dashboard',[UtilisateursController::class ,'Adminp'])->name('Admin');
    Route::get('/Supervisor-dashboard',[UtilisateursController::class ,'Supervisorp'])->name('Supervisor');
    Route::get('/Mail-dashboard',[UtilisateursController::class ,'Mailp'])->name('Mail');
    Route::get('/Print-dashboard',[UtilisateursController::class ,'Printp'])->name('Print');

    //ADMIN ROUTES

    //Edit Logged user
    Route::get('/edit-profil{id}',[UtilisateursController::class,'editprofil'])->name('editprof');
    Route::post('/update-profil/{id}',[UtilisateursController::class,'updateprofil']);
    //Create user(Admin-only feature)
    Route::get('/create-user',[UtilisateursController::class,'createUser'])->name('createUser');
    Route::post('/insert-user',[UtilisateursController::class,'insertUser'])->name('insertUser');
    //Edit user
    Route::get('/edit-user{id}',[UtilisateursController::class,'editUser']);
    Route::post('/update-user/{id}',[UtilisateursController::class,'updateUser']);
    //Delete user(Admin-only feature)
    Route::get('/delete-user/{id}', [UtilisateursController::class , 'deleteUser']);
    //Send Email
    Route::get('/contact',[ContactController::class, 'index'])->name('email.index');
    Route::post('/send',[ContactController::class, 'send'])->name('email.send');
    //send multiple emails
    Route::get('/email',[MultiMailController::class, 'index'])->name('multimail.index');
    Route::post('/sendd',[MultiMailController::class, 'send'])->name('multimail.send');
    //Create Client
    Route::get('/create-client',[UtilisateursController::class,'createClient'])->name('createClient');
    Route::post('/insert-client',[UtilisateursController::class,'insertClient'])->name('insertClient');
    //Client List
    Route::get('/client-list',[UtilisateursController::class,'clientList'])->name('clientList');
    //Edit Client
    Route::get('/edit-client{id}',[UtilisateursController::class,'editClient']);
    Route::post('/update-client/{id}',[UtilisateursController::class,'updateClient']);
    //Delete Client
    Route::get('/delete-client/{id}', [UtilisateursController::class , 'deleteClient']);
    //Stats Page
    Route::get('/stats',[UtilisateursController::class,'statp'])->name('stats');
    //Print Page
    Route::get('/printer',[printerController::class,'index'])->name('printer');
    Route::post('/print',[printController::class,'index'])->name('print');

    //SUPERVISOR ROUTES
    
    //Edit Profile
    Route::get('/supervisor-edit-profil{id}',[UtilisateursController::class,'editprofilsup'])->name('editprofsup');
    Route::post('/supervisor-update-profil/{id}',[UtilisateursController::class,'updateprofilsup']);
    //Create User
    Route::get('/supervisor-create-user',[UtilisateursController::class,'createUsersup'])->name('createUsersup');
    Route::post('/supervisor-insert-user',[UtilisateursController::class,'insertUsersup'])->name('insertUsersup');
    //Edit User
    Route::get('/supervisor-edit-user{id}',[UtilisateursController::class,'editUsersup']);
    Route::post('/supervisor-update-user/{id}',[UtilisateursController::class,'updateUsersup']);
    //Send email
    Route::get('/supervisor-contact',[ContactController::class, 'indexsup'])->name('email.indexsup');
    //send multiple emails
    Route::get('/supervisor-email',[MultiMailController::class, 'indexsup'])->name('multimail.indexsup');
    //Client list
    Route::get('/supervisor-client-list',[UtilisateursController::class,'clientListsup'])->name('clientListsup');
    //Stats Page
    Route::get('/supervisor-stats',[UtilisateursController::class,'statpsup'])->name('statssup');
    //Print Page
    Route::get('/supervisor-printer',[printerController::class,'indexsup'])->name('printersup');
    Route::post('/supervisor-print',[printController::class,'indexsup'])->name('printsup');

    //MAILING AGENT ROUTES
    
    //Edit Profile
    Route::get('/agentm-edit-profil{id}',[UtilisateursController::class,'editprofilagentm'])->name('editprofagentm');
    Route::post('/agentm-update-profil/{id}',[UtilisateursController::class,'updateprofilagentm']);
    //Send email
    Route::get('/agentm-contact',[ContactController::class, 'indexagentm'])->name('email.indexagentm');
    //send multiple emails
    Route::get('/agentm-email',[MultiMailController::class, 'indexagentm'])->name('multimail.indexagentm');
    //Client list
    Route::get('/agentm-client-list',[UtilisateursController::class,'clientListagentm'])->name('clientListagentm');

    //PRINTING AGENT ROUTES

    //Edit Profile
    Route::get('/agentp-edit-profil{id}',[UtilisateursController::class,'editprofilagentp'])->name('editprofagentp');
    Route::post('/agentp-update-profil/{id}',[UtilisateursController::class,'updateprofilagentp']);
    //Client list
    Route::get('/agentp-client-list',[UtilisateursController::class,'clientListagentp'])->name('clientListagentp');
    //Print Page
    Route::get('/agentp-printer',[printerController::class,'indexagentp'])->name('printeragentp');
    Route::post('/agentp-print',[printController::class,'indexagentp'])->name('printagentp');
});  
