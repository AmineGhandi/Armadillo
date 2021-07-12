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
    Route::get('/print',[printController::class,'index'])->name('print');
    
});  
