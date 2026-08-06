<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ChatController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\website\ContactController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE ROUTES (Frontend)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('website.pages.index'); })->name('home');

Route::get('/menu', [MenuItemController::class, 'websiteIndex'])->name('menu');
Route::get('/reservation', [ReservationController::class, 'websiteIndex'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('/contact', function () { return view('website.pages.contact'); })->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/send-email', [MailController::class, 'sendEmail'])->name('send.email');

/*
|--------------------------------------------------------------------------
| CART & CHECKOUT ROUTES (Session-Based)
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

Route::get('/order-confirmation/{id}', [App\Http\Controllers\OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');

Route::post('/place-order', [OrderController::class, 'placeOrderFromWeb'])->name('place-order');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Protected by Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', function () { return view('admin.pages.index'); })->name('dashboard');

    // --- E-Commerce & Product ---
    Route::get('/ecommerce', function () { return view('admin.pages.e_commerce'); })->name('ecommerce');
    Route::get('/product/detail', function () { return view('admin.pages.product_detail'); })->name('product.detail');
    Route::get('/pricing/tables', function () { return view('admin.pages.pricing_tables'); })->name('pricing.tables');

    // --- Orders & Invoices ---
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/order/detail', function () { return view('admin.pages.order_detail'); })->name('order.detail');

    // Note: These are handled by InvoiceController
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice');
    Route::match(['get', 'post'], '/invoices/data', [InvoiceController::class, 'getInvoicesData'])->name('invoices.data');

    // --- Tables & Charts ---
    Route::get('/tables', [CustomerController::class, 'adminIndex'])->name('tables');
    Route::get('/tables/dynamic', [OrderController::class, 'adminIndex'])->name('tables.dynamic');
    Route::get('/charts', function () { return view('admin.pages.echarts'); })->name('charts');
    Route::get('/echarts', function () { return view('admin.pages.echarts'); })->name('echarts');
    Route::get('/charts/other', function () { return view('admin.pages.other_charts'); })->name('other.charts');

    // --- Menu Management ---
    Route::get('/menu', [MenuItemController::class, 'adminIndex'])->name('menu');
    Route::get('/menu/addmenu', [MenuItemController::class, 'addmenu'])->name('addmenu');
    Route::post('/menu/addmenu', [MenuItemController::class, 'storeAddmenu'])->name('addmenu.store');
    Route::get('/menu/editmenu/{id}', [MenuItemController::class, 'editmenu'])->name('editmenu');
    Route::put('/menu/editmenu/{id}', [MenuItemController::class, 'updateEditmenu'])->name('editmenu.update');
    Route::delete('/menu/{id}', [MenuItemController::class, 'destroyMenu'])->name('menu.destroy');

    // --- Purchases ---
    Route::get('/purchases', [PurchaseController::class, 'adminIndex'])->name('purchases');
    Route::get('/purchases/addpurchase', [PurchaseController::class, 'addpurchase'])->name('addpurchase');
    Route::post('/purchases/addpurchase', [PurchaseController::class, 'storeAddpurchase'])->name('addpurchase.store');
    Route::get('/purchases/{id}', [PurchaseController::class, 'show'])->name('purchases.show');

    // --- Reservations ---
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations');
    Route::get('/reservations/data', [ReservationController::class, 'getReservationsData'])->name('reservations.data');
    Route::get('/reservations/export', [ReservationController::class, 'exportCsv'])->name('reservations.export');
    Route::get('/reservations/addreservation', [ReservationController::class, 'addreservation'])->name('addreservation');
    Route::post('/reservations/addreservation', [ReservationController::class, 'storeAddreservation'])->name('addreservation.store');
    Route::get('/reservations/editreservation/{id}', [ReservationController::class, 'editreservation'])->name('editreservation');
    Route::put('/reservations/editreservation/{id}', [ReservationController::class, 'updateEditreservation'])->name('editreservation.update');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroyReservation'])->name('reservation.destroy');

    // --- Chat / Contact Messages ---
    Route::get('/contacts', [ContactController::class, 'adminIndex'])->name('contacts');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{id}', [MailController::class, 'getChatMessages'])->name('chat.messages');
    Route::post('/chat/send', [MailController::class, 'sendReply'])->name('chat.send');

    // --- Projects & Theme ---
    Route::get('/projects', function () { return view('admin.pages.projects'); })->name('projects');
    Route::get('/project/detail', function () { return view('admin.pages.project_detail'); })->name('project.detail');
    Route::get('/theme', function () { return view('admin.pages.theme'); })->name('theme');

    // --- User Management & Profile ---
    Route::get('/user', [UserController::class, 'adminIndex'])->name('user');
    Route::get('/profile', function () { return view('admin.pages.profile'); })->name('profile');
    Route::get('/settings', function () { return view('admin.pages.settings'); })->name('settings');
    Route::get('/faq', function () { return view('admin.pages.faq'); })->name('faq');
    Route::get('/lock/screen', function () { return view('admin.pages.lock_screen'); })->name('lock.screen');

});

/*
|--------------------------------------------------------------------------
| EXTRA / TOP-LEVEL ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/index2', function () { return view('admin.pages.index2'); })->name('index2');
Route::get('/index3', [DashboardController::class, 'sales'])->name('index3');
Route::get('/lock-screen', function () { return view('admin.pages.lock_screen'); })->name('lock.screen');

/*
|--------------------------------------------------------------------------
| DUMMY AUTH ROUTES (For login page links)
|--------------------------------------------------------------------------
*/
Route::get('/register', function () { return redirect('/login'); })->name('register');
Route::get('/password/reset', function () { return redirect('/login'); })->name('password.request');
Route::get('/password/reset/{token}', function () { return redirect('/login'); })->name('password.reset');