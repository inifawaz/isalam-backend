<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectcategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUpdateController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionInquiryController;
use App\Models\ProjectCategory;
use App\Models\TransactionInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/projects/categories', [ProjectCategoryController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::post('/transactions', [TransactionController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/getpaymentmethod', [PaymentController::class, 'getPaymentMethod']);
    Route::post('/payments', [PaymentController::class, 'createPayment']);

    Route::post('/checkpaymentstatus', [PaymentController::class, 'checkPaymentStatus']);
    Route::get('/payments', [PaymentController::class, 'index']);

    Route::get('/me/projects', [MeController::class, 'getProjects']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::post('/projects/categories', [ProjectCategoryController::class, 'store']);

    Route::post('/projects', [ProjectController::class, 'store']);
    Route::post('/projects/{project}/updates', [ProjectUpdateController::class, 'store']);
});
