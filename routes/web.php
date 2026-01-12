<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\AboutController as FrontendAboutController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\TestimonialController as FrontendTestimonialController;
use App\Http\Controllers\Frontend\ServicesController as FrontendServicesController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// Customer Controllers
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ReservationController as CustomerReservationController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Customer\TestimonialController as CustomerTestimonialController;

//1. PUBLIC ROUTES

Route::get('/', [FrontendHomeController::class, 'index'])->name('public.home');
Route::get('/about', [FrontendAboutController::class, 'index'])->name('public.about');
Route::get('/contact', [FrontendContactController::class, 'index'])->name('public.contact');
Route::post('/contact/send', [FrontendContactController::class, 'submit'])->name('contact.send');
Route::get('/gallery', [FrontendGalleryController::class, 'index'])->name('public.gallery');
Route::get('/menu', [FrontendMenuController::class, 'index'])->name('public.menu');
Route::get('/testimonial', [FrontendTestimonialController::class, 'index'])->name('public.testimonial');

Route::prefix('services')->name('public.services.')->group(function() {
    Route::get('/', [FrontendServicesController::class, 'index'])->name('index');
    Route::get('/galadinner', [FrontendServicesController::class, 'galaDinner'])->name('galaDinner');
    Route::get('/tour', [FrontendServicesController::class, 'tour'])->name('tour');
    Route::get('/cookingclass', [FrontendServicesController::class, 'cookingClass'])->name('cookingClass');
});

Route::get('/reservasi', [FrontendReservationController::class, 'create'])->name('public.reservation');

// 2. AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// 3. ADMIN ROUTES
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/financial-report', [AdminDashboardController::class, 'financialReport'])->name('financial-report');

    // Untuk Rute aksi POST untuk reservation
    Route::post('/reservation/{id}/approve', [AdminReservationController::class, 'approve'])->name('reservation.approve');
    Route::post('/reservation/{id}/reject', [AdminReservationController::class, 'reject'])->name('reservation.reject');
    Route::post('/reservation/{id}/complete', [AdminReservationController::class, 'completeReservation'])->name('reservation.complete');
    Route::post('/contact/{id}/reply', [AdminContactController::class, 'reply'])->name('contact.reply');

    Route::resource('reservation', AdminReservationController::class);
    Route::resource('gallery', AdminGalleryController::class);
    Route::resource('menu', AdminMenuController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('contact', AdminContactController::class);

    // Custom routes untuk riviews
    Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');

    Route::resource('reviews', AdminReviewController::class);
});

// 4. CUSTOMER ROUTES
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Reservations
    Route::resource('reservation', CustomerReservationController::class);
    Route::get('reservation/{reservation}/download-ticket', [CustomerReservationController::class, 'downloadTicket'])->name('reservation.downloadTicket');
    Route::get('reservation/{reservation}/view-ticket', [CustomerReservationController::class, 'viewTicket'])->name('reservation.viewTicket');
    Route::get('reservation/statuses/get', [CustomerReservationController::class, 'getStatuses'])->name('reservation.statuses');

    // New Payment Routes
    Route::prefix('payment')->name('payment.')->group(function() {
        Route::get('/', [CustomerPaymentController::class, 'index'])->name('index');
        Route::get('/{reservation}/pay', [CustomerPaymentController::class, 'showPayPage'])->name('pay');
        Route::post('/{reservation}/pay', [CustomerPaymentController::class, 'pay'])->name('pay.post');
        Route::post('/{reservation}/process', [CustomerPaymentController::class, 'process'])->name('process');
        Route::get('/{reservation}/invoice', [CustomerPaymentController::class, 'downloadInvoice'])->name('invoice');
        Route::get('/test-midtrans', [CustomerPaymentController::class, 'testMidtrans'])->name('test-midtrans');
    });

    Route::get('reservation/{reservation}/ticket', [CustomerPaymentController::class, 'downloadTicket'])->name('reservation.ticket');

    // Profile & Review
    Route::get('/profile', [CustomerProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [CustomerProfileController::class, 'changePassword'])->name('profile.changePassword');

    Route::get('/reviews/create', [CustomerReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');

    // Testimonial routes
    Route::get('/testimoni', [CustomerTestimonialController::class, 'index'])->name('testimoni.index');
    Route::get('/testimoni/create/{reservation}', [CustomerTestimonialController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni', [CustomerTestimonialController::class, 'store'])->name('testimoni.store');
});

// 5. MIDTRANS CALLBACK
Route::post('/midtrans/callback', [CustomerPaymentController::class, 'callback'])->name('midtrans.callback');


//database test

