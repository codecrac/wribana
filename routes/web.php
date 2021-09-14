<?php

use App\Http\Controllers\EspaceMenbre;
use App\Http\Controllers\MenbreController;
use Illuminate\Support\Facades\Route;

/*
|********* |*********|********* Routes  Vitrine |*********|*********|*********
|********* |*********|********* Routes  Vitrine |*********|*********|*********
*/

Route::get('/', function () {
    $is_home=true; return view('welcome',['is_home'=>$is_home]);
})->name('accueil');

Route::get('/comment-ca-marche', function () {
    $current=true; return view('comment_ca_marche',['is_comment_ca_marche'=>$current]);
})->name('comment_ca_marche');

Route::get('/qui-sommes-nous', function () {
    $current=true; return view('apropos',['is_apropos'=>$current]);
})->name('apropos');

Route::get('/faq', function () {
    $current=true; return view('faq',['is_faq'=>$current]);
})->name('faq');

Route::get('/contact', function () {
    $current=true; return view('contact',['is_contact'=>$current]);
})->name('contact');

Route::get('/connexion-menbre', function () { return view('connexion_menbre'); })->name('connexion_menbre');

Route::get('/inscription-menbre', function () {return view('inscription_menbre');})->name('inscription_menbre');

Route::post('/inscription-menbre', [MenbreController::class,'enregistrer_un_menbre'])->name('post_inscription_menbre');
Route::post('/connexion-menbre',  [MenbreController::class,'connexion'])->name('post_connexion_menbre');


#===================================================================
Route::prefix('/espace-menbre')->middleware('menbre_connecter')->group(function (){
    Route::get("/",[EspaceMenbre::class,'accueil'])->name('espace_menbre.accueil');
    Route::get("/deconnexion",[EspaceMenbre::class,'deconnexion'])->name('espace_menbre.deconnexion');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
