<?php



use Illuminate\Support\Facades\Route;

Route::get('/shops', [\App\Http\Controllers\Api\ShopApiController::class, 'showAll']);

Route::post('/shops', [\App\Http\Controllers\Api\ShopApiController::class, 'store']);

Route::get('/transactions', [\App\Http\Controllers\Api\TransactionApiController::class, 'getAll']);
Route::post('/transactions', [\App\Http\Controllers\Api\TransactionApiController::class, 'store']);


Route::delete('/transactions', [\App\Http\Controllers\Api\TransactionApiController::class, 'delete']);
