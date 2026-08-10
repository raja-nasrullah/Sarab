<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ChatController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\ContactController;
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
| ADMIN SUBDOMAIN ROUTES (admin.sarab.site) - ALL ADMIN ROUTES HERE
|--------------------------------------------------------------------------
*/
Route::domain('admin.sarab.site')->group(function () {
    
    // Admin Login Routes (No middleware)
    Route::get('/', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

    // All Protected Admin Routes (with 'admin' middleware)
    Route::middleware(['admin'])->group(function () {
        
        // --- Dashboard ---
        Route::get('/dashboard', function () { return view('admin.pages.index'); })->name('admin.dashboard');

        // --- E-Commerce & Product ---
        Route::get('/ecommerce', function () { return view('admin.pages.e_commerce'); })->name('admin.ecommerce');
        Route::get('/product/detail', function () { return view('admin.pages.product_detail'); })->name('admin.product.detail');
        Route::get('/pricing/tables', function () { return view('admin.pages.pricing_tables'); })->name('admin.pricing.tables');

        // --- Orders & Invoices ---
        Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/order/detail', function () { return view('admin.pages.order_detail'); })->name('admin.order.detail');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('admin.invoices');
        Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('admin.invoice');
        Route::match(['get', 'post'], '/invoices/data', [InvoiceController::class, 'getInvoicesData'])->name('admin.invoices.data');

        // --- Tables & Charts ---
        Route::get('/tables', [CustomerController::class, 'adminIndex'])->name('admin.tables');
        Route::get('/tables/dynamic', [OrderController::class, 'adminIndex'])->name('admin.tables.dynamic');
        Route::get('/charts', function () { return view('admin.pages.echarts'); })->name('admin.charts');
        Route::get('/echarts', function () { return view('admin.pages.echarts'); })->name('admin.echarts');
        Route::get('/charts/other', function () { return view('admin.pages.other_charts'); })->name('admin.other.charts');

        // --- Menu Management ---
        Route::get('/menu', [MenuItemController::class, 'adminIndex'])->name('admin.menu');
        Route::get('/menu/addmenu', [MenuItemController::class, 'addmenu'])->name('admin.addmenu');
        Route::post('/menu/addmenu', [MenuItemController::class, 'storeAddmenu'])->name('admin.addmenu.store');
        Route::get('/menu/editmenu/{id}', [MenuItemController::class, 'editmenu'])->name('admin.editmenu');
        Route::put('/menu/editmenu/{id}', [MenuItemController::class, 'updateEditmenu'])->name('admin.editmenu.update');
        Route::delete('/menu/{id}', [MenuItemController::class, 'destroyMenu'])->name('admin.menu.destroy');

        // --- Purchases ---
        Route::get('/purchases', [PurchaseController::class, 'adminIndex'])->name('admin.purchases');
        Route::get('/purchases/addpurchase', [PurchaseController::class, 'addpurchase'])->name('admin.addpurchase');
        Route::post('/purchases/addpurchase', [PurchaseController::class, 'storeAddpurchase'])->name('admin.addpurchase.store');
        Route::get('/purchases/{id}', [PurchaseController::class, 'show'])->name('admin.purchases.show');

        // --- Reservations ---
        Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('admin.reservations');
        Route::get('/reservations/data', [ReservationController::class, 'getReservationsData'])->name('admin.reservations.data');
        Route::get('/reservations/export', [ReservationController::class, 'exportCsv'])->name('admin.reservations.export');
        Route::get('/reservations/addreservation', [ReservationController::class, 'addreservation'])->name('admin.addreservation');
        Route::post('/reservations/addreservation', [ReservationController::class, 'storeAddreservation'])->name('admin.addreservation.store');
        Route::get('/reservations/editreservation/{id}', [ReservationController::class, 'editreservation'])->name('admin.editreservation');
        Route::put('/reservations/editreservation/{id}', [ReservationController::class, 'updateEditreservation'])->name('admin.editreservation.update');
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroyReservation'])->name('admin.reservation.destroy');

        // --- Chat / Contact Messages ---
        Route::get('/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts');
        Route::get('/chat', [ChatController::class, 'index'])->name('admin.chat');
        Route::get('/chat/messages/{id}', [MailController::class, 'getChatMessages'])->name('admin.chat.messages');
        Route::post('/chat/send', [MailController::class, 'sendReply'])->name('admin.chat.send');

        // --- Projects & Theme ---
        Route::get('/projects', function () { return view('admin.pages.projects'); })->name('admin.projects');
        Route::get('/project/detail', function () { return view('admin.pages.project_detail'); })->name('admin.project.detail');
        Route::get('/theme', function () { return view('admin.pages.theme'); })->name('admin.theme');

        // --- User Management & Profile ---
        Route::get('/user', [UserController::class, 'adminIndex'])->name('admin.user');
        Route::get('/profile', function () { return view('admin.pages.profile'); })->name('admin.profile');
        Route::get('/settings', function () { return view('admin.pages.settings'); })->name('admin.settings');
        Route::get('/faq', function () { return view('admin.pages.faq'); })->name('admin.faq');
        Route::get('/lock/screen', function () { return view('admin.pages.lock_screen'); })->name('admin.lock.screen');
    });
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (Main Domain - sarab.site)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE ROUTES (Main Domain - sarab.site)
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
| EXTRA / TOP-LEVEL ROUTES (Main Domain - sarab.site)
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