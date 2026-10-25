<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

// Redirect home to catalog
Route::get('/', function () {
    return redirect()->route('catalog');
})->name('home');

// Language switcher (accessible to all)
Route::get('/locale/{lang}', [LocaleController::class, 'switchLocale'])->name('locale.switch');

// Catalog exploration (Guest & Authenticated)
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Authentication (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated User Features
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Watchlist & Tracking
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/{series}', [WatchlistController::class, 'storeOrUpdate'])->name('watchlist.store');
    Route::post('/watchlist/{series}/increment', [WatchlistController::class, 'incrementProgress'])->name('watchlist.increment');
    Route::post('/watchlist/{series}/decrement', [WatchlistController::class, 'decrementProgress'])->name('watchlist.decrement');
    Route::delete('/watchlist/{series}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');

    // Reviews & Ratings
    Route::post('/series/{series}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Manager Portal (Manager & Admin)
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/series', [ManagerController::class, 'index'])->name('series.index');
    Route::get('/series/create', [ManagerController::class, 'createSeries'])->name('series.create');
    Route::post('/series', [ManagerController::class, 'storeSeries'])->name('series.store');
    Route::get('/series/{series}/edit', [ManagerController::class, 'editSeries'])->name('series.edit');
    Route::put('/series/{series}', [ManagerController::class, 'updateSeries'])->name('series.update');
    Route::delete('/series/{series}', [ManagerController::class, 'destroySeries'])->name('series.destroy');

    // Episodes
    Route::get('/series/{series}/episodes', [ManagerController::class, 'episodes'])->name('series.episodes');
    Route::post('/series/{series}/episodes', [ManagerController::class, 'storeEpisode'])->name('series.episodes.store');
    Route::delete('/episodes/{episode}', [ManagerController::class, 'destroyEpisode'])->name('episodes.destroy');

    // Genres
    Route::get('/genres', [ManagerController::class, 'genres'])->name('genres.index');
    Route::post('/genres', [ManagerController::class, 'storeGenre'])->name('genres.store');
    Route::delete('/genres/{genre}', [ManagerController::class, 'destroyGenre'])->name('genres.destroy');

    // Moderation
    Route::get('/moderation', [ManagerController::class, 'moderation'])->name('moderation.index');
    Route::post('/moderation/{review}/toggle', [ManagerController::class, 'toggleReviewApproval'])->name('moderation.toggle');
    Route::delete('/moderation/{review}', [ManagerController::class, 'destroyModeratedReview'])->name('moderation.destroy');
});

// Administrator Panel (Admin Only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});
