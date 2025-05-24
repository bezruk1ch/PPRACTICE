<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConstructorController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;

use App\Models\Template;

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

Route::middleware(['auth'])->group(function () {
    // Корзина
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/calculate-price', [CartController::class, 'calculatePrice'])->name('cart.calculate-price');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
});

// Тест страница
Route::get('/test', [TestController::class, 'index'])->name('test');

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Конструктор
Route::get('/constructor', [ConstructorController::class, 'index'])->name('constructor');

// Портфолио
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

// О нас
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Контакты
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');  // Здесь используем POST
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
});

// Личный кабинет
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/profile/review', [ProfileController::class, 'storeReview'])->name('profile.review');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/register');
})->name('logout');


// Отзывы

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
require __DIR__ . '/auth.php';
