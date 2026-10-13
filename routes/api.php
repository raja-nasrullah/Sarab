<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\ContactController;

//Controller -> Auth
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

// Add this for Passport
use Laravel\Passport\Http\Controllers\AccessTokenController;

/*
|--------------------------------------------------------------------------
| PASSPORT OAUTH TOKEN ENDPOINT (Critical!)
|--------------------------------------------------------------------------
*/
// This is the endpoint Postman will use to get tokens
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);

/*
|--------------------------------------------------------------------------
| PUBLIC AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
// Register - Public
Route::post('/register', [RegisterController::class, 'register']);

// Login - Rate limited to prevent brute force
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:5,1'); // 5 attempts per minute

// Public menu item detail for website modal
Route::get('/menu-items/{id}', [MenuItemController::class, 'show'])
    ->name('api.menu.item');

/*
|--------------------------------------------------------------------------
| PROTECTED API ROUTES (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tables', RestaurantTableController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('reservations', ReservationController::class);
    Route::apiResource('inventory', InventoryController::class);
    Route::apiResource('purchases', PurchaseController::class);
    Route::apiResource('purchase-items', PurchaseItemController::class);
});