<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConstructorController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
Route::prefix('constructor')->group(function () {
    Route::get('/design', [ConstructorController::class, 'index'])->name('constructor.index');
    Route::get('/template/{type}/{id}', [ConstructorController::class, 'selectTemplate'])->name('constructor.select');
    Route::post('/save', [ConstructorController::class, 'saveDesign'])->name('constructor.save');
    Route::get('/preview/{id}', [ConstructorController::class, 'previewDesign'])->name('constructor.preview');
    Route::post('/print/{id}', [ConstructorController::class, 'sendToPrint'])->name('constructor.print');
    Route::get('/templates/{type}', [ConstructorController::class, 'getTemplatesByType'])->name('constructor.templates');
});

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

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
