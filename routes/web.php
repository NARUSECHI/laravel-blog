<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

Route::group(['middleware'=>'auth'],function(){
    Route::get('/',[PostController::class,'index'])->name('index');

    #Post ROUTES
    Route::group(['prefix' => 'post','as'=>'post.'], function(){
        //prefix ~~ it will add a URI '/post' ~~ /post/create
        //as     ~~ assignes a name for all the routes inside the group ~~ post.create
        Route::get('/create', [PostController::class,'create'])->name('create');
        Route::post('/store',[PostController::class,'store'])->name('store');
        Route::get('/show/{id}',[PostController::class,'show'])->name('show');
        Route::get('/edit/{id}',[PostController::class,'edit'])->name('edit');
        Route::patch('/update/{id}',[PostController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[PostController::class,'destroy'])->name('destroy');
    });
});


