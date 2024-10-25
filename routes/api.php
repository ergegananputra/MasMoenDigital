<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPesertaController;

Route::prefix('v0')->group(function () {
    Route::get('/peserta', [DataPesertaController::class, 'index']);
    Route::post('/peserta', [DataPesertaController::class, 'store']);
    Route::get('/peserta/{id}', [DataPesertaController::class, 'show']);
});
