<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ControllerCategories;
use App\Http\Controllers\sharesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Dashboard',[AuthController::class,'index'])->middleware('auth', 'banned');
Route::get('/login',[AuthController::class,'login_page'])->name('login');
Route::get('/Rigester',[AuthController::class,'Rigester_page']);
Route::post('/create_user',[AuthController::class,'create_user']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);

Route::post('/create_colocation',[ColocationController::class,'create_colocation'])->middleware('auth', 'banned');
Route::get('/colocation/{coloc}',[ColocationController::class,'Colocation_page'])->middleware('auth', 'banned');
Route::post('/add_member/{coloc}',[ColocationController::class,'invite_email'])->middleware('auth', 'banned');
Route::get('/inv/{token}',[ColocationController::class,'invitation_page'])->middleware('auth', 'banned');
Route::get('/accept/{token}',[ColocationController::class,'accept_coloc'])->middleware('auth', 'banned');

Route::post('/create_Categories/{coloc}',[ControllerCategories::class,'create_Category'])->middleware('auth', 'banned');

Route::middleware(['admin', 'banned', 'auth'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'admin']);
        Route::post('/ban/{user}', [AdminController::class, 'ban'])->name('admin.ban');
        Route::post('/unban/{user}', [AdminController::class, 'unban'])->name('admin.unban');
});
Route::middleware(['banned', 'auth'])->group(function () {
    Route::post('/colocation/{coloc}/expense', [sharesController::class, 'create_expense']);
    Route::post('/expense/{expence_id}/pay/{id}', [sharesController::class, 'pay']);
    Route::post('/colocation/{coloc}/quit/{user}', [sharesController::class, 'quit']);
    Route::post('/colocation/{coloc}/kick/{user}', [sharesController::class, 'kick']);
});
