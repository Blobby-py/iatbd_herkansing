<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

// Show homepage and products listing
Route::get('/', [ProductController::class, 'index']);

// Show user details
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth');

// Show the create page for products
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Store new product data
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Show edit page for a product
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware('auth');

// Submit updated product data
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth');

// Delete a product
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('auth');

// Show product details page
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Show Register Form
Route::get('/register', [UserController::class, 'registreren'])->middleware('guest');

// Create new user account
Route::post('/users', [UserController::class, 'aanmaken']);

// Logout user
Route::post('/logout', [UserController::class, 'uitloggen'])->middleware('auth');

// Show login form
Route::get('/login', [UserController::class, 'inloggen'])->middleware('guest')->name('login');

// Authenticate user
Route::post('/users/authenticate', [UserController::class, 'authenticeren']);

// Search
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// Reviews
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('products.reviews.store');

// Rent a product
Route::get('/products/{product}/rent', [ProductController::class, 'rent'])->name('products.rent')->middleware('auth');

// Return rented product
Route::get('/products/{product}/return', [ProductController::class, 'returnProduct'])->name('products.return')->middleware('auth');

