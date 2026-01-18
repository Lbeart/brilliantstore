<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
// Public controllers
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController as ShopProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\OrderTrackingController;

/*
|--------------------------------------------------------------------------
| Public / Website
|--------------------------------------------------------------------------
*/
// routes/web.php


Route::get('/track', [OrderTrackingController::class, 'form'])->name('track.form');//
Route::get('/track/{code}', [OrderTrackingController::class, 'show'])->name('track.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
// 🏠 Home
Route::get('/', [ItemController::class, 'index'])->name('home');

// 📄 Static
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/terms', fn () => view('pages.terms'))->name('terms');       // nëse s’i ke, krijoi blades
Route::get('/privacy', fn () => view('pages.privacy'))->name('privacy'); // pages/terms.blade.php, pages/privacy.blade.php

// 📬 Contact
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])
    ->middleware('throttle:5,1') // anti-spam
    ->name('contact.send');

// 🌐 Language
Route::get('/lang/{lang}', function (string $lang) {
    // opsionale: lejo vetëm gjuhët që i ke
    if (!in_array($lang, ['sq','en'])) { $lang = 'sq'; }
    session(['locale' => $lang]);
    app()->setLocale($lang);
    return back();
})->name('lang.switch');

// 🛍 Storefront – lista & detajet (publike)
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ShopProductController::class, 'show'])->name('products.show');

// 🗂 Kategori
Route::get('/tepiha',         [ShopProductController::class, 'tepiha'])->name('products.tepiha');
Route::get('/anesore',        [ShopProductController::class, 'anesore'])->name('products.anesore');
Route::get('/postava',        [ShopProductController::class, 'postava'])->name('products.postava');
Route::get('/mbulesa',        [ShopProductController::class, 'mbulesa'])->name('products.mbulesa');
Route::get('/jastekdekorues', [ShopProductController::class, 'jastekdekorues'])->name('products.jastekdekorues');
Route::get('/batanije',       [ShopProductController::class, 'batanije'])->name('products.batanije');
Route::get('/tepihebanjo',    [ShopProductController::class, 'tepihebanjo'])->name('products.tepihebanjo');
Route::get('/posteqia',       [ShopProductController::class, 'posteqia'])->name('products.posteqia');
Route::get('/perde-ditore',   [ShopProductController::class, 'perdeDitore'])->name('products.perdeDitore');
Route::get('/garnishte', [ShopProductController::class, 'garnishte'])->name('products.garnishte');/*
|--------------------------------------------------------------------------
| Auth (manual)
|--------------------------------------------------------------------------
*/

Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class, 'login']);
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// Email verify
Route::get('/email/verify', fn () => view('auth.verify-email'))
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed','throttle:6,1'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Linku i verifikimit u dërgua në email.');
})->middleware(['auth','throttle:6,1'])->name('verification.send');

// Password reset
Route::get('/forgot-password',  [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',  [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Cart & Checkout (publike)
|--------------------------------------------------------------------------
*/

Route::get('/cart',          [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',     [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',  [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',  [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])
    ->name('checkout.success');


Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('throttle:10,1') // mbrojtje nga spam
    ->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Admin (auth + verified + admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

        // Users
        Route::get('/users',                 [UserController::class, 'index'])->name('users');
        Route::get('/users/{user}/edit',     [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',          [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',       [UserController::class, 'destroy'])->name('users.destroy');

        // Products
        Route::get('/products',                 [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create',          [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products',                [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit',  [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}',       [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}',    [AdminProductController::class, 'destroy'])->name('products.destroy');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

        // ✅ Shiko të gjitha – PARA {order}
        Route::get('/orders/all', [AdminOrderController::class, 'all'])->name('orders.all');

        // Show / Update / Email / Delete (with numeric constraint)
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->whereNumber('order')->name('orders.show');

        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->whereNumber('order')->name('orders.status');

        Route::post('/orders/{order}/email', [AdminOrderController::class, 'sendConfirmationEmail'])
            ->whereNumber('order')->name('orders.email');

        Route::post('/orders/{order}/email-shipped', [AdminOrderController::class, 'sendShippedEmail'])
            ->whereNumber('order')->name('orders.email_shipped');

        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])
            ->whereNumber('order')->name('orders.destroy');

        // Stats
        Route::get('/statistika', [StatsController::class, 'index'])->name('stats');
    });

/*
|--------------------------------------------------------------------------
| Fallback 404 (opsionale)
|--------------------------------------------------------------------------
*/
// Route::fallback(fn() => abort(404));

