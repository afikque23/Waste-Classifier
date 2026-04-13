<?php

use App\Http\Controllers\AnalysisController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnalysisController::class, 'home'])->name('home');
Route::post('/analyze', [AnalysisController::class, 'analyze'])->name('analyze');

// Result
Route::get('/result/{analysis}', [AnalysisController::class, 'result'])->name('result.show');
Route::get('/result', function () {
    return redirect()->route('history')->with('info', 'Pilih salah satu hasil analisis dari History.');
})->name('result');

// History + Team
Route::get('/history', [AnalysisController::class, 'history'])->name('history');
Route::get('/team', [AnalysisController::class, 'team'])->name('team');

// Download
Route::get('/download/{analysis}', [AnalysisController::class, 'download'])->name('download');
