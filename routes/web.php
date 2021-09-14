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
Route::get('/comment-ca-marche', function () { return view('comment_ca_marche'); })->name('comment_ca_marche');
Route::get('/qui-sommes-nous', function () { return view('apropos'); })->name('apropos');
Route::get('/faq', function () { return view('faq'); })->name('faq');
Route::get('/contact', function () { return view('contact'); })->name('contact');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
