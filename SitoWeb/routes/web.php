<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;


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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Creazione del gruppo
Route::get('/groupStart', [GroupController::class, 'start'])->name('groupStart')->middleware('auth');
Route::post('/groupCreate', [GroupController::class, 'create'])->name('groupCreate')->middleware('auth');


// Gestione del gruppo
Route::post('/groupInfo', [GroupController::class, 'info'])->name('groupInfo')->middleware('auth');
Route::post('/groupManagerChanges', [GroupController::class, 'managerChanges'])->name('groupManagerChanges')->middleware('auth');

// Lista di prodotti 
Route::post('/pageManagerProduct', [ProductController::class, 'pageManagerProduct'])->name('pageManagerProduct')->middleware('auth');

// Modifica visiblità del prodotto
Route::post('/visibleProduct', [ProductController::class, 'visibleProduct'])->name('visibleProduct')->middleware('auth');

// Aggiunta di prodotti
Route::post('/addProduct', [ProductController::class, 'add'])->name('addProduct')->middleware('auth');
Route::post('/addProductRequest', [ProductController::class, 'addRequest'])->name('addProductRequest')->middleware('auth');

// Modifica prodotto
Route::post('/editProduct', [ProductController::class, 'editProduct'])->name('editProduct')->middleware('auth');
Route::post('/saveEditProduct', [ProductController::class, 'saveEditProduct'])->name('saveEditProduct')->middleware('auth');

// Lista dei gruppi
Route::get('/listGroup', [ParticipationController::class, 'list'])->name('listGroup')->middleware('auth');

//Cambia gruppo
Route::get('/changeGroup', [GroupController::class, 'change'])->name('changeGroup')->middleware('auth');

//Richiesta di accesso
Route::post('/requestAccessSend', [ParticipationController::class, 'requestAccessSend'])->name('requestAccessSend')->middleware('auth');
Route::get('/requestAccessPage/{group}', [ParticipationController::class, 'requestAccessPage'])->name('requestAccessPage')->middleware('auth');
Route::post('/setParticipations', [ParticipationController::class, 'setParticipations'])->name('setParticipations')->middleware('auth');

// Lista partecipanti 
Route::get('/listParticipants/{group}', [ParticipationController::class, 'listParticipants'])->name('listParticipants')->middleware('auth');
Route::post('/block', [ParticipationController::class, 'block'])->name('block')->middleware('auth');

//Ordinare 
Route::post('/order', [ProductController::class, 'order'])->name('order')->middleware('auth');
Route::post('/saveOrder', [ProductController::class, 'saveOrder'])->name('saveOrder')->middleware('auth');
Route::post('/approveProducts', [GroupController::class, 'approveProduct'])->name('approveProducts')->middleware('auth');


//Fatture
Route::post('/invoce', [InvoiceController::class, 'invoceShow'])->name('invoce')->middleware('auth');
Route::post('/createPDF', [InvoiceController::class, 'createPDF'])->name('createPDF')->middleware('auth');

//User
Route::get('/user', [UserController::class, 'getInfo'])->name('user')->middleware('auth');
Route::post('/saveNewInfo', [UserController::class, 'saveNewInfo'])->name('saveNewInfo')->middleware('auth');