<?php

use App\Http\Controllers\Api\SalesContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->get('/sales_contracts', [SalesContractController::class, 'index']);