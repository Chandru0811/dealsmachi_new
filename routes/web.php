<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\CartController;

Route::fallback(function () {
    return redirect()->route('home');
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
Route::middleware('auth')->group(function () {
    Route::get('/checkoutSummary/{product_id}', [CheckoutController::class, 'checkoutsummary'])->name('checkout.summary');
    Route::get('/checkout/{cart_id}', [CheckoutController::class, 'cartcheckout'])->name('checkout.cart');
    Route::post('/directCheckout', [CheckoutController::class, 'directcheckout'])->name('checkout.direct');


    Route::get('/cartSummary/{cart_id}', [CartController::class, 'cartSummary'])->name('cart.address');
    Route::post('/checkout', [CheckoutController::class, 'createorder'])->name('checkout.checkout');
    Route::post('/createAddress', [AddressController::class, 'store'])->name('address.create');
    Route::put('/updateAddress', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/selectaddress', [AddressController::class, 'changeSelectedId'])->name('address.change');
    Route::get('/orders', [CheckoutController::class, 'getAllOrdersByCustomer'])->name('customer.orders');
    Route::get('/order/{id}/{product_id}', [CheckoutController::class, 'showOrderByCustomerId'])->name('customer.orderById');
    Route::get('/order/invoice/{id}', [CheckoutController::class, 'orderInvoice'])->name('order.invoice');
    Route::put('/updateUser', [HomeController::class, 'updateUser'])->name('user.update');
    Route::post('/review', [HomeController::class, 'createReview'])->name('review.create');
});

Route::get('get/cartitems', [CartController::class, 'getCartItem'])->name('cartitems.get');
Route::post('addtocart/{slug}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::Post('cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::post('cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('cart/dropdown', [CartController::class, 'getCartDropdown'])->name('cart.dropdown');
Route::post('saveforlater/add', [CartController::class, 'saveForLater'])->name('savelater.add');
// Route::post('saveforlater/multiple', [CartController::class, 'multipleMoveToCart'])->name('savelater.multiple');
Route::post('saveforlater/toCart', [CartController::class, 'moveToCart'])->name('movetocart');
Route::post('saveforlater/remove', [CartController::class, 'removeFromSaveLater'])->name('savelater.remove');
Route::get('saveforlater/all', [CartController::class, 'getsaveforlater'])->name('savelater.index');

Route::get('/privacyPolicy', function () {
    return view('privacyPolicy');
});
Route::get('/terms_conditions', function () {
    return view('termsandconditions');
});
Route::get('/contactus', function () {
    return view('contactus');
});



Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Check if user already exists
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // If the user does not exist, create a new user
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(), // Optionally store avatar
            'password' => bcrypt(12345678), // Set a random password
        ]);
    }

    // Log the user in
    Auth::login($user);

    return redirect('/');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
