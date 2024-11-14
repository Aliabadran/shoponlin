npm install<?php

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\GeneralFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PreferencesController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




// Email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/'); // Redirect after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');



//Route::get('/feedback_show', [FeedbackController::class, 'showFeedbackDetails'])->name('feedback.details');



Route::get('/', [HomeController::class, 'index'])->name('home');



Route::post('/track-ad-interaction', [AdController::class, 'trackAdInteraction'])->middleware('auth');
Route::get('/ads/interactions', [AdController::class, 'showAdsBasedOnInteraction'])->middleware('auth')->name('ads.interaction_ads');
// Show the preferences page
Route::get('/preferences', [PreferencesController::class, 'showPreferences'])->middleware('auth')->name('preferences.show');
// Store the preferences
Route::post('/preferences/store', [PreferencesController::class, 'storePreferences'])->middleware('auth')->name('preferences.store');




Route::get('/home/ads', [HomeController::class, 'ads'])->name('home.ads');
Route::get('/home/product', [HomeController::class, 'product'])->name('home.product');
Route::get('/home/product/{id}/details', [HomeController::class, 'productdetails'])->name('home.productdetails');
Route::get('/home/category', [HomeController::class, 'category'])->name('home.category');
Route::get('/home/category/{id}/products', [HomeController::class, 'showProductsInCategory'])->name('home.category.products');
Route::post('/comments/{type}/{id}', [CommentController::class, 'store'])->name('comments.store'); // E.g., /comments/product/1
Route::get('/general-feedback', function () {
    $feedbacks = Feedback::with('comments.replies.user')->get();
    return view('home.general_feedback', compact('feedbacks'));
})->name('general');


Route::get('home/ads/user', [HomeController::class, 'showAds'])->middleware('auth')->name('user.ads');

Route::post('/comments/reply/{id}', [CommentController::class, 'reply'])->name('comments.reply');
Route::get('/comments/edit/{id}', [CommentController::class, 'edit'])->name('comments.edit');
Route::delete('/comments/destroy/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::post('/comments/update/{id}', [CommentController::class, 'update'])->name('comments.update');





    Route::middleware(['auth'])->group(function () {
        // User routes
        Route::get('/feedback', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.form');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback/{id}/reply', [FeedbackController::class, 'reply'])->name('feedback.reply');

        // Admin routes
        Route::middleware(['role:Super Admin|Admin'])->group(function () {
            // Route::get('/feedback1', [FeedbackController::class, 'index'])->name('admin.feedback.index');
            Route::get('/feedback/manage', [FeedbackController::class, 'review'])->name('admin.feedback.manage');
            Route::post('/feedback/{id}/publish', [FeedbackController::class, 'publish'])->name('admin.feedback.publish');
            Route::post('/feedback/{id}/status', [FeedbackController::class, 'updateStatus'])->name('admin.feedback.updateStatus');
            Route::post('/feedback/{id}/toggle-visibility', [FeedbackController::class, 'toggleVisibility'])->name('admin.feedback.toggleVisibility');
        });

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
   // Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.confirm');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/order/{order_id}/detaill', [OrderController::class, 'OrderDetails'])->name('order.detaill');
    Route::get('/order/success/{order_id}', [OrderController::class, 'orderSuccess'])->name('order.success');
    Route::post('orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/order-verification/{user}/{order}', [OrderController::class, 'showOrderVerification'])->name('order.verification');
    // Admin routes
    Route::middleware(['role:Super Admin|Admin'])->group(function () {
      Route::get('/orders', [OrderController::class, 'showAllOrders'])->name('orders.all');
      Route::get('/order/{order_id}/details', [OrderController::class, 'getOrderDetails'])->name('order.details');
      Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
      Route::get('/orders/{id}/pdf', [OrderController::class, 'generateOrderPdf'])->name('orders.pdf.download');
        Route::get('/order/verify/{order}/{hash}', [OrderController::class, 'verifyOrder'])->name('order.verify');
     Route::get('/orders/{id}/view-pdf', [OrderController::class, 'viewOrderPdf'])->name('orders.pdf.view');
     Route::get('/order/{id}/pdf', [OrderController::class, 'generateOrderPDF'])->name('order.pdf');
    });
});







Route::middleware('auth')->group(function () {
    Route::post('/notifications/{id}/read', function ($id) {
        Auth::user()->notifications()->find($id)->markAsRead();
         return back();
     })->name('notifications.read');
     Route::get('/notifications/user', [NotificationController::class, 'index'])->name('notifications.index-user');
     Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
     Route::get('/notifications/user11', [NotificationController::class, 'show'])->name('notifications.unread');
});


Route::middleware(['role:Super Admin|Admin'])->group(function () {
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/home/ads', [AdController::class, 'showAdsToUser'])->name('ads.user');
    Route::get('/ads/show', [AdController::class, 'showAds']);

  // Admin routes
    Route::middleware(['role:Super Admin|Admin'])->group(function () {
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::get('/contacts', [ContactController::class, 'showContacts'])->name('admin.contacts');
    });

});

// routes/web.php

Route::get('/notify-all', [NotificationController::class, 'notifyUserWithAll']);



require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';

