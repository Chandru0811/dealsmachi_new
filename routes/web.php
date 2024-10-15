<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('hotpick/{slug}', [HomeController::class, 'dealcategorybasedproducts']);
Route::get('categories/{slug}', [HomeController::class, 'subcategorybasedproducts'])->name('subcategorybasedproducts');
Route::get('deal/{id}', [HomeController::class, 'productdescription']);
Route::get('bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('bookmark/{deal_id}/add', [BookmarkController::class, 'add'])->name('bookmarks.add');
Route::delete('bookmark/{deal_id}/remove', [BookmarkController::class, 'remove'])->name('bookmarks.remove');
Route::get('totalbookmark', [BookmarkController::class, 'totalItems'])->name('bookmarks.totalItems');
Route::get('search', [HomeController::class, 'search'])->name('search');
Route::get('/privacyPolicy', function () {
    return view('privacyPolicy');
});
Route::get('/terms_conditions', function () {
    return view('termsandconditions');
});



















// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';
