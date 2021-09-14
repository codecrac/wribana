<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
