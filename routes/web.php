<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Buyer\BuyerController;

// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isSeller()) return redirect()->route('seller.dashboard');
        return redirect()->route('buyer.dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
    Route::post('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/sellers', [AdminController::class, 'sellerReport'])->name('reports.sellers');
    Route::get('/reports/buyers', [AdminController::class, 'buyerReport'])->name('reports.buyers');
    Route::get('/reports/pricing', [AdminController::class, 'pricingReport'])->name('reports.pricing');
    
    // Listings & Transactions
    Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    
    // Rice Listings
    Route::get('/listings', [SellerController::class, 'listings'])->name('listings');
    Route::get('/listings/create', [SellerController::class, 'createListing'])->name('listings.create');
    Route::post('/listings', [SellerController::class, 'storeListing'])->name('listings.store');
    Route::get('/listings/{id}/edit', [SellerController::class, 'editListing'])->name('listings.edit');
    Route::put('/listings/{id}', [SellerController::class, 'updateListing'])->name('listings.update');
    Route::delete('/listings/{id}', [SellerController::class, 'deleteListing'])->name('listings.delete');
    
    // Orders
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [SellerController::class, 'viewOrder'])->name('orders.view');
    Route::post('/orders/{id}/complete', [SellerController::class, 'completeOrder'])->name('orders.complete');
    
    // Profile
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');
});

// Buyer Routes
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    
    // Browse Listings
    Route::get('/browse', [BuyerController::class, 'browse'])->name('browse');
    Route::get('/listings/{id}', [BuyerController::class, 'viewListing'])->name('listings.view');
    
    // Orders
    Route::get('/listings/{id}/order', [BuyerController::class, 'placeOrderForm'])->name('place-order');
    Route::post('/listings/{id}/order', [BuyerController::class, 'placeOrder'])->name('place-order.submit');
    Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [BuyerController::class, 'viewOrder'])->name('orders.view');
    
    // Feedback
    Route::get('/orders/{id}/feedback', [BuyerController::class, 'submitFeedbackForm'])->name('feedback');
    Route::post('/orders/{id}/feedback', [BuyerController::class, 'submitFeedback'])->name('feedback.submit');
});

