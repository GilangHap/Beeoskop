<?php

use App\Livewire\About;
use App\Livewire\Profile;
use App\Livewire\User\Home;
use App\Livewire\Admin\Film;
use App\Livewire\Admin\Genre;
use App\Livewire\Admin\Users;
use App\Livewire\User\Movies;
use App\Livewire\Admin\Studio;
use App\Livewire\User\Checkout;
use App\Livewire\Admin\FilmForm;
use App\Livewire\Admin\Dashboard;
use App\Livewire\User\DetailFilm;
use App\Livewire\Admin\Screenings;
use App\Livewire\Admin\StudioSeats;
use App\Livewire\Admin\Transaction;
use App\Livewire\User\Transactions;
use App\Livewire\User\SeatSelection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\PaymentVerification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');
Route::get('/movie/{id}', DetailFilm::class)->name('movie.detail');
Route::get('/movies', Movies::class)->name('movies');
Route::get('/seat-selection/{id}', SeatSelection::class)->name('seat.selection');
Route::get('/checkout', Checkout::class)->name('checkout')->middleware('auth');


Route::get('/about', About::class)->name('about');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', function() {
        return view('auth.register');
    })->name('register');

    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');

    Route::get('/forgot-password', function() {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/tickets', function () {
        return view('tickets');
    })->name('tickets');

    Route::get('/my-transactions', Transactions::class)->name('user.transactions');
    Route::get('/profile', Profile::class)->name('profile');
        
});

// Admin routes - Using specific class reference instead of alias
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Content Management
    Route::get('/genre', Genre::class)->name('genre');
    Route::get('/film', Film::class)->name('film');
    Route::get('/film/create', FilmForm::class)->name('film.create');
    Route::get('/film/edit/{id}', FilmForm::class)->name('film.edit');
    Route::get('/studio', Studio::class)->name('studio');
    Route::get('/studio/{id}/seats', StudioSeats::class)->name('studio.seats');
    Route::get('/screenings', Screenings::class)->name('screenings');
    
    // User Management
    Route::get('/users', Users::class)->name('users');
    
    // Transaction Management
    Route::get('/transactions', Transaction::class)->name('transactions');
    Route::get('/verification', PaymentVerification::class)->name('verification');

    // Reports
    // Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    // Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
});

// Redirect /dashboard to appropriate location based on user role
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    return Auth::user()->role === 'admin' 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('home');
})->name('dashboard');