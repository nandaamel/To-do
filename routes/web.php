<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
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
Route::middleware('isLogin')->group(function() {
    Route::get('/dashboard/create',[TodoController::class, 'create'])->name('create');
    Route::post('/store', [TodoController::class, 'store'])->name('store');
    //route path yang menggunakan {} berarti dia berperan sebagai parameter route
    //parameter ini bentuknya data dinamis (data yang dikirim ke route untuk diambil di parameter function controller terkait)
    Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
    //method route untuk ubah data di db itu patch/put
    Route::get('/update/{id}', [TodoController::class, 'update'])->name('update');
    Route::get('/', [TodoController::class, 'index']);
});
Route::get('/login',[TodoController::class, 'login']);
Route::get('/logout',[TodoController::class, 'logout']);
Route::get('/register', [TodoController::class, 'register']);
Route::post('/register/input', [TodoController::class, 'registerAccount'])->name('register.input');
Route::post('/login/auth',[TodoController::class, 'auth'])->name('login.auth');
Route::get('/create',[TodoController::class, 'create'])->name('create.io');
Route::delete('/delete/{id}', [TodoController::class, 'destroy'])->name('delete');
Route::patch('/complated/{id}', [TodoController::class,'updateCompleted'])->name('ipdate.complated');
Route::get('/edit',[TodoController::class, 'edit'])->name('edit');
