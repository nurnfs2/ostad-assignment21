<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication routes
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

// Protected routes (require JWT authentication)
Route::middleware('jwt.auth')->group(function () {
    Route::get('todo-items', 'TodoItemController@index');
    Route::post('todo-items', 'TodoItemController@store');
    Route::get('todo-items/{id}', 'TodoItemController@show');
    Route::put('todo-items/{id}', 'TodoItemController@update');
    Route::delete('todo-items/{id}', 'TodoItemController@destroy');
});
