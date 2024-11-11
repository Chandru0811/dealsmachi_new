<?php

use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/', [HomeController::class, 'index']);
Route::get('hotpick/{slug}', [HomeController::class, 'dealcategorybasedproducts']);
Route::get('categories/{slug}', [HomeController::class, 'subcategorybasedproducts'])->name('subcategorybasedproducts');
Route::get('deal/{id}', [HomeController::class, 'productdescription']);
Route::get('bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('bookmark/{deal_id}/add', [BookmarkController::class, 'add'])->name('bookmarks.add');
Route::delete('bookmark/{deal_id}/remove', [BookmarkController::class, 'remove'])->name('bookmarks.remove');
Route::get('totalbookmark', [BookmarkController::class, 'totalItems'])->name('bookmarks.totalItems');
Route::get('search', [HomeController::class, 'search'])->name('search');
Route::post('deals/count/click', [HomeController::class, 'clickcounts']);
Route::post('deals/count/views', [HomeController::class, 'viewcounts']);
Route::post('deals/coupon/copied', [HomeController::class, 'couponCodeCopied']);
Route::post('deals/count/share', [HomeController::class, 'dealshare']);
Route::post('deals/count/enquire', [HomeController::class, 'dealenquire']);
Route::get('/checkout', function () {
    return view('checkout');
});
Route::get('/privacyPolicy', function () {
    return view('privacyPolicy');
});
Route::get('/terms_conditions', function () {
    return view('termsandconditions');
});
Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/register', function () {
    return view('auth/register');
});
Route::get('/forgot-password', function () {
    return view('auth/forgot-password');
});
Route::get('/contactus', function () {
    return view('contactus');
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
