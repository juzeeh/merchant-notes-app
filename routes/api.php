<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\NoteController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Merchant routes
Route::get('/merchants', [MerchantController::class, 'index']);
Route::get('/merchants/{id}', [MerchantController::class, 'show']);
Route::get('/merchants/{id}/notes', [MerchantController::class, 'notes']);

// Note routes
Route::get('/merchants/{merchant}/notes/search', [NoteController::class, 'search']);
Route::post('/merchants/{merchant}/notes', [NoteController::class, 'store']);
Route::put('/notes/{id}', [NoteController::class, 'update']);
Route::delete('/notes/{id}', [NoteController::class, 'destroy']);