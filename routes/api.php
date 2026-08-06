<?php

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
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('menu-items', MenuItemController::class);
Route::apiResource('tables', RestaurantTableController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('inventory', InventoryController::class);
Route::apiResource('purchases', PurchaseController::class);
Route::apiResource('purchase-items', PurchaseItemController::class);
Route::apiResource('contacts', ContactController::class); 
// Route::apiResource('users', UserController::class);