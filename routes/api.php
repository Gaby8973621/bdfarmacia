<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FrontController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ProductoController;
use App\Http\Controllers\Api\Admin\CategoriaController;
//aqui le puse un alias para que no me de error
use App\Http\Controllers\Api\Client\ProductoController as ProductoClient;




//rutas con el prefijo de v1
Route::prefix('v1')->group(function () {
    //rutas publicas el prefijo va a ser public
    //para mostrar todos los roductos de una categoria
    //las rutas publicas no le vamos a poner autentificacion
    Route::get('/public/{slug}',[FrontController::class,'categoria']);

    //prefijo de login y registro va a ser auth
    Route::get('/auth/register',[AuthController::class,'register']);
    Route::get('/auth/login',[AuthController::class,'login']);

    //rutas privadas
    // a estas rutas si le vamos a poner autentificacion
    //vamos a usar un token
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        //rutas para el cliente
        Route::apiResource('/client/producto', ProductoController::class);

        //rutas para el admin
        Route::apiResource('/admin/user', UserController::class);
        Route::apiResource('/admin/categoria', CategoriaController::class);
        Route::apiResource('/admin/producto', ProductoClient::class);
    });


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
