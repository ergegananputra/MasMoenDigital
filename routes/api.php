<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPesertaController;

Route::prefix('v0')->middleware('api-key-data-peserta')->group(function () {
    Route::get('/peserta', [DataPesertaController::class, 'index']);
    Route::post('/peserta', [DataPesertaController::class, 'store']);
    Route::get('/peserta/{id}', [DataPesertaController::class, 'show']);
    Route::delete('/peserta/{id}', [DataPesertaController::class, 'destroy']);
});
