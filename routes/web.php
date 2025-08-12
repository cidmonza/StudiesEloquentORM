<?php

use App\Http\Controllers\MainController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/oneToOne', [MainController::class, 'oneToOne']);
Route::get('/oneToMany', [MainController::class, 'oneToMany']);
Route::get('/belongsTo', [MainController::class, 'belongsTo']);
Route::get('/manyToMany', [MainController::class, 'manyToMany']);

