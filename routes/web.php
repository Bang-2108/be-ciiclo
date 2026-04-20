<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::middleware('guest')->group(function() {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']) ->name('register.post');
});

use Illuminate\Support\Facades\Storage;


Route::get('/check-minio', function () {
    try {
        Storage::disk('s3')->put('hello_ciiclo.txt', 'Configured successfully at: ' . now());
        
        return "<h1>Congratulations!</h1><p>The file was uploaded to MinIO successfully. Please check it in the MinIO web interface.</p>";
    } catch (\Exception $e) {
        return "<h1>Failed!</h1><p>Error: " . $e->getMessage() . "</p>";
    }
});