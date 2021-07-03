<?php

use App\Http\Controllers\UtilisateursController;
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


Route::group(['middleware'=>['AuthCheck']],function(){
    Route::get('/admin-dashboard',[UtilisateursController::class ,'Adminp'])->name('Admin');
    Route::get('/Supervisor-dashboard',[UtilisateursController::class ,'Supervisorp'])->name('Supervisor');
    Route::get('/Mail-dashboard',[UtilisateursController::class ,'Mailp'])->name('Mail');
    Route::get('/Print-dashboard',[UtilisateursController::class ,'Printp'])->name('Print');
    Route::get('/login',[UtilisateursController::class ,'login'])->name('login');
    Route::get('/edit-profil{id}',[UtilisateursController::class,'editprofil'])->name('editprof');
    Route::post('/update-user/{id}',[UtilisateursController::class,'updateUser']);
});