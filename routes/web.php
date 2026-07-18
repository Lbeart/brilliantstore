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
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LegacyImageController;
use App\Http\Controllers\ChatbotController;

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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\PointOfSaleController as AdminPointOfSaleController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\Admin\AdminAssistantController;

/*
|--------------------------------------------------------------------------
| Public / Website
|--------------------------------------------------------------------------
*/
// routes/web.php
Route::get('/invoice/{id}', [AdminOrderController::class, 'invoicePublic'])
    ->middleware('signed')
    ->name('orders.invoice.public');

Route::get('/receipt/{receipt}/invoice', [AdminCustomerController::class, 'publicReceiptInvoice'])
    ->middleware('signed')
    ->name('customers.invoice.public');


Route::get('/track', [OrderTrackingController::class, 'form'])->name('track.form');//
Route::get('/track/{code}', [OrderTrackingController::class, 'show'])->name('track.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/chatbot/message', ChatbotController::class)
    ->middleware('throttle:chatbot')
    ->name('chatbot.message');
Route::get('/legacy-image/{encoded}', [LegacyImageController::class, 'show'])
    ->where('encoded', '[A-Za-z0-9\-_]+')
    ->name('legacy.image');

Route::get('/storage/products/{filename}', function (string $filename) {
    $filename = basename($filename);
    $path = storage_path('app/public/products/'.$filename);

    abort_unless(is_file($path), 404);

    return response()->file($path);
})->where('filename', '[A-Za-z0-9._-]+')->name('storage.products.fallback');
// 🏠 Home
Route::get('/', [ItemController::class, 'index'])->name('home');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/add-curtain', [CartController::class, 'addCurtain'])->name('cart.addCurtain');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


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
    if (!in_array($lang, ['sq', 'en', 'sr'], true)) { $lang = 'sq'; }
    session(['locale' => $lang]);
    session()->save();
    app()->setLocale($lang);
    return back();
})->name('lang.switch');

// 🛍 Storefront – lista & detajet (publike)
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ShopProductController::class, 'show'])
    ->missing(function (Request $request) {
        return app(ShopProductController::class)->legacyRedirect(
            $request,
            (string) $request->route('product')
        );
    })
    ->name('products.show');

// 🗂 Kategori
Route::get('/tepiha',         [ShopProductController::class, 'tepiha'])->name('products.tepiha');
Route::get('/perde',          [ShopProductController::class, 'perde'])->name('products.perde');
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

Route::middleware(['auth', 'verified'])
    ->prefix('account')
    ->name('account.')
    ->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');
    });

/*
|--------------------------------------------------------------------------
| Cart & Checkout (publike)
|--------------------------------------------------------------------------
*/

Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('throttle:10,1') // mbrojtje nga spam
    ->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');


use App\Http\Controllers\SitemapController;

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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/assistant/message', AdminAssistantController::class)
            ->middleware('throttle:20,1')
            ->name('assistant.message');

        // Users
        Route::get('/users',                 [UserController::class, 'index'])->name('users');
        Route::get('/users/{user}/edit',     [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',          [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',       [UserController::class, 'destroy'])->name('users.destroy');

        // Customers
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [AdminCustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/reports/daily/{date}/invoice', [AdminCustomerController::class, 'dailyInvoice'])
            ->where('date', '\d{4}-\d{2}-\d{2}')
            ->name('customers.daily-invoice');
        Route::get('/customers/reports/daily/{date}/invoice-pdf', [AdminCustomerController::class, 'dailyInvoicePdf'])
            ->where('date', '\d{4}-\d{2}-\d{2}')
            ->name('customers.daily-invoice.pdf');
        Route::get('/customers/{customer}/edit', [AdminCustomerController::class, 'edit'])->whereNumber('customer')->name('customers.edit');
        Route::put('/customers/{customer}', [AdminCustomerController::class, 'update'])->whereNumber('customer')->name('customers.update');
        Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy'])->whereNumber('customer')->name('customers.destroy');
        Route::post('/customers/{customer}/purchases', [AdminCustomerController::class, 'storePurchase'])->whereNumber('customer')->name('customers.purchases.store');
        Route::delete('/customers/{customer}/purchases/{purchase}', [AdminCustomerController::class, 'destroyPurchase'])->whereNumber('customer')->whereNumber('purchase')->name('customers.purchases.destroy');
        Route::put('/customers/{customer}/receipts/{receipt}/payment', [AdminCustomerController::class, 'updateReceiptPayment'])->whereNumber('customer')->whereNumber('receipt')->name('customers.receipts.payment');
        Route::post('/customers/{customer}/receipts/{receipt}/send-invoice', [AdminCustomerController::class, 'sendReceiptInvoice'])->whereNumber('customer')->whereNumber('receipt')->name('customers.receipts.send');
        Route::get('/customers/{customer}/receipts/{receiptCode}/invoice', [AdminCustomerController::class, 'invoice'])->whereNumber('customer')->name('customers.invoice');
        Route::get('/customers/{customer}/receipts/{receiptCode}/invoice-pdf', [AdminCustomerController::class, 'invoicePdf'])->whereNumber('customer')->name('customers.invoice.pdf');

        // POS
        Route::get('/pos', [AdminPointOfSaleController::class, 'index'])->name('pos.index');
        Route::get('/pos/lookup', [AdminPointOfSaleController::class, 'lookup'])->name('pos.lookup');
        Route::post('/pos/checkout', [AdminPointOfSaleController::class, 'checkout'])->name('pos.checkout');

        // Products
        Route::get('/products',                 [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create',          [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products',                [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/barcode', [AdminProductController::class, 'barcode'])->name('products.barcode');
        Route::get('/products/{product}/edit',  [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}',       [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}',    [AdminProductController::class, 'destroy'])->name('products.destroy');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

        // ✅ Shiko të gjitha – PARA {order}
        Route::get('/orders/all', [AdminOrderController::class, 'all'])->name('orders.all');

        // Show / Update / Email / Delete (with numeric constraint)
        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])
    ->name('orders.invoice');
    Route::get('/orders/{order}/invoice-pdf', [AdminOrderController::class, 'invoicePdf'])
    ->name('orders.invoice.pdf');

Route::post('/orders/{order}/send-invoice', [AdminOrderController::class, 'sendInvoice'])
    ->name('orders.sendInvoice');
   
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->whereNumber('order')->name('orders.show');

        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->whereNumber('order')->name('orders.status');

        Route::post('/orders/{order}/email', [AdminOrderController::class, 'sendConfirmationEmail'])
            ->whereNumber('order')->name('orders.email');

        Route::post('/orders/{order}/email-shipped', [AdminOrderController::class, 'sendShippedEmail'])
            ->whereNumber('order')->name('orders.email_shipped');

        Route::post('/orders/{order}/email-canceled', [AdminOrderController::class, 'sendCanceledEmail'])
            ->whereNumber('order')->name('orders.email_canceled');

        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])
            ->whereNumber('order')->name('orders.destroy');

        // Stats
        Route::get('/statistika', [StatsController::class, 'index'])->name('stats');

        

        
    });


Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/sitemap-products.xml', [SitemapController::class, 'products']);
/*
|--------------------------------------------------------------------------
| Fallback 404 (opsionale)
|--------------------------------------------------------------------------
*/
// Route::fallback(fn() => abort(404));
