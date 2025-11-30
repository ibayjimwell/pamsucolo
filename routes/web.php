<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\StudentVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public main page
Route::get('/', function () {
    return view('main');
})->name('main');

// Add POST for direct verification from registration form (AJAX)
Route::post('user/verify', [StudentVerificationController::class, 'verifyStudent'])->name('student.verifyStudent');

Route::post('register/verify-credentials', [StudentVerificationController::class, 'verifyRegisterCredentials'])->name('student.verifyRegisterCredentials');


Route::get('/admin', function () {
    return view('components.admin');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');

Route::get('verify-email', EmailVerificationPromptController::class)
->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

// Everything else: shop, product, bag, account, admin, checkout...
Route::middleware('auth')->group(function () {
    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/shop/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/bag', [CartController::class, 'index'])->name('cart.index');
    Route::post('/shop/{product}/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/bag/{cartItem}/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/bag/{cartItem}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/loan', [AccountController::class, 'requestLoan'])->name('account.loan');
    // Admin
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/product', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::post('/admin/product/{product}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::post('/admin/product/{product}/delete', [AdminController::class, 'destroyProduct'])->name('admin.product.delete');
    Route::post('/admin/loan/{loan}/approve', [AdminController::class, 'approveLoan'])->name('admin.loan.approve');
    Route::post('/admin/loan/{loan}/decline', [AdminController::class, 'declineLoan'])->name('admin.loan.decline');
});

