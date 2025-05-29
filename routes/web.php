<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConstructorController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;




use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as ReviewAdminController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\FeedbackController;



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

// Админка — только для залогиненных и с ролью admin
Route::prefix('admin')
    ->middleware(['auth', 'can:admin'])
    ->name('admin.')
    ->group(function () {
        // вместо view() → перенаправляем на контроллер или в dashboard.blade
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Список заказов
        Route::get('orders', [AdminOrderController::class, 'index'])
            ->name('orders');
        // Просмотр одного заказа
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');
        // Обновление статуса заказа
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])
            ->name('orders.destroy');

        // Пользователи
        Route::get('users',         [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::patch('users/{user}',   [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}',  [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{review}/edit', [ReviewAdminController::class, 'edit'])->name('reviews.edit');
        Route::put('reviews/{review}', [ReviewAdminController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    });

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');


// Добавить в корзину — сессия
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// Оформить заказ (запись в БД)
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Сброс корзины
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


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

// Личный кабинет
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

Route::post('/profile/review', [ProfileController::class, 'storeReview'])->name('profile.review');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/register');
})->name('logout');


// Отзывы

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
require __DIR__ . '/auth.php';
