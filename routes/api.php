<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('users', function() {
//     return "Hello World";
// });
// Route::post('users', function(){
//     return response()->json("Api hit sucessfuly");
// });

// Route::delete('users/{id}',function($id){
//     return response()->json($id,200);
// });
// Route::get('/test', function (){
//     p('working');
// });

Route::post('user/store',[App\Http\Controllers\Api\UserController::class, 'store']);
Route::get('user/get/{flag}',[App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('user/{id}',[App\Http\Controllers\Api\UserController::class, 'show']);
Route::delete('user/delete/{id}',[App\Http\Controllers\Api\UserController::class, 'destroy']);
