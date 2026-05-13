<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('register');
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