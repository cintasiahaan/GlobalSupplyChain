<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplyChainApiController;

/*
|--------------------------------------------------------------------------
| REST API Routes (Specified in Project Specification)
|--------------------------------------------------------------------------
*/

Route::get('/countries', [SupplyChainApiController::class, 'countries']);
Route::get('/risk', [SupplyChainApiController::class, 'risk']);
Route::get('/ports', [SupplyChainApiController::class, 'ports']);
Route::get('/news', [SupplyChainApiController::class, 'news']);
Route::get('/currency', [SupplyChainApiController::class, 'currency']);
