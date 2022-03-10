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

/*Route::get('/', function () {
    return view('welcome');
});*/


use Illuminate\Http\Request;

/*Route::post('/token/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});


Route::middleware('auth:sanctum')->get('/api/user', function (Request $request) {
    return $request->user();
});

Route::post('/api/login', function (Request $request) {
    {
        
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
 
            return $request->user();
        }
 
        return abort(400,"hiba");
    }

});*/

use App\Http\Controllers\UserController;
use App\Http\Controllers\FontosController;

Route::post('api/login', [UserController::class, "login"]);
Route::post('api/check', [UserController::class, "check"]);
Route::post('api/logout', [UserController::class, "logout"]);

Route::post('api/fontos', [FontosController::class, "fontos"]);
