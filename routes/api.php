<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/login', function(){
    return response()->json([
        'error' => 'Unauthenticated', 
    ], 401);
})->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    //lister formation
     Route::get('formation/lister', [FormationController::class, 'index']);
    //ajouter formation
     Route::post('formation/create', [FormationController::class, 'store']);
    //pour modifier formation
     Route::put('Formation/edit/{id}', [FormationController::class, 'update']);
    //pour supprimer formation
    Route::put('formation/delete/{id}', [FormationController::class, 'delete']);

