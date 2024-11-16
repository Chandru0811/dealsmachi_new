<?php

use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('hotpick/{slug}', [HomeController::class, 'dealcategorybasedproducts'])->name('deals.categorybased');
Route::get('categories/{slug}', [HomeController::class, 'subcategorybasedproducts'])->name('deals.subcategorybased');
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

//Auth
Route::get('/sociallogin/{provider}/{role}', [AuthController::class, 'socialredirect']);
Route::get('/social/{provider}/callback', [AuthController::class, 'handlesociallogin']);
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/directCheckout/{product_id}', [CheckoutController::class, 'directcheckout'])->name('checkout.direct');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.checkout');
    Route::get('/orders', [CheckoutController::class, 'getAllOrdersByCustomer'])->name('customer.orders');
    Route::get('/orders/{id}', [CheckoutController::class, 'showOrderByCustomerId'])->name('customer.orderById');
});

Route::get('/support', function () {
    return view('support');
});
Route::get('/privacyPolicy', function () {
    return view('privacypolicy');
});
Route::get('/terms_conditions', function () {
    return view('termsandconditions');
});
Route::get('/contactus', function () {
    return view('contactus');
});
Route::get('/checkout', function () {
    return view('checkout');
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
