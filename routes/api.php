<?php

use App\Http\Controllers\FinancialAssetController;
use App\Http\Controllers\NegotiationNoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/financial-assets', FinancialAssetController::class);
Route::apiResource('/negotiation-notes', NegotiationNoteController::class);
