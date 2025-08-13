<?php

use App\Http\Controllers\MainController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/oneToOne', [MainController::class, 'OneToOne']);
Route::get('/oneToMany', [MainController::class, 'OneToMany']);
Route::get('/belongsTo', [MainController::class, 'BelongsTo']);
Route::get('/manyToMany', [MainController::class, 'ManyToMany']);
Route::get('/queries', [MainController::class, 'RunningQueries']);
Route::get('/sameResults', [MainController::class, 'SameResults']);

