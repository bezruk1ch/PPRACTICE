<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConstructorController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Конструктор
Route::get('/constructor', [ConstructorController::class, 'index'])->name('constructor.index');
Route::get('/constructor/{category_id}', [ConstructorController::class, 'templates'])->name('constructor.templates');
Route::get('/constructor/templates/{category}', [ConstructorController::class, 'showTemplates'])->name('constructor.templates');
Route::get('/constructor/edit/{template}', [ConstructorController::class, 'edit'])->name('constructor.edit');
Route::put('/constructor/update/{template}', [ConstructorController::class, 'update'])->name('constructor.update');
Route::get('constructor/templates/{template}/edit', [ConstructorController::class, 'edit'])->name('constructor.edit');
Route::post('constructor/templates/{template}', [ConstructorController::class, 'save'])->name('constructor.save');

// Портфолио
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

// О нас
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Контакты
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/slides', [AdminController::class, 'updateSlides'])->name('admin.slides.update');
    Route::post('/admin/orders/update', [AdminController::class, 'updateOrders'])->name('admin.orders.update');
    Route::post('/admin/reviews/update', [AdminController::class, 'updateReviews'])->name('admin.reviews.update');
    Route::post('/admin/users/update', [AdminController::class, 'updateUsers'])->name('admin.users.update');
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
