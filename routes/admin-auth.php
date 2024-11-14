<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationContentController;

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'verified']);
 //   Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');})->middleware(['auth', 'verified']);
 Route::get('/char', [DashboardController::class, 'show'])->name('admin.chars')->middleware(['auth', 'verified']);

 Route::get('/check', [SearchController::class, 'check'])->name('admin.check');

});
Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
Route::resource('coupons', CouponController::class, ['as' => 'admin']);
});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);
    Route::get('/category/{id}/products', [CategoryController::class, 'showProducts'])->name('category.products');

});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::resource('products', ProductController::class);
    Route::get('/category/{id}/products', [CategoryController::class, 'showProducts'])->name('category.products');
    Route::get('/product/search', [SearchController::class, 'ProductSearchHome'])->name('product.search');

});
Route::get('/products/{id}/categories', [ProductController::class, 'showProductsCategory'])->name('products.categories');


Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth')->name('tasks');
    Route::post('/tasks', [TaskController::class, 'store'])->middleware('auth')->name('admin.tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->middleware('auth')->name('admin.tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware('auth')->name('admin.tasks.destroy');
});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::get('/notifications2', [AdminController::class, 'index'])->name('admin.notifications');
    Route::post('/notifications2/{id}/mark-as-read', [AdminController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    Route::post('/notifications2/{id}/mark-as-unread', [AdminController::class, 'markAsUnread'])->name('admin.notifications.markAsUnread');
 //   Route::get('/admin/notifications', [AdminController::class, 'showAllNotifications'])->name('admin.notifications.index');
});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::resource('ads', AdController::class);
});

Route::group(['middleware' => ['role:Super Admin|Admin']], function() {
    Route::resource('notificationsOffer', NotificationContentController::class);
});


Route::get('/pdf', [PdfController::class, 'generatePdf'])->name('pdf.generate');
Route::get('/orders/pdf',  [PdfController::class, 'generateAllOrdersPDF'])->name('orders.pdf');
