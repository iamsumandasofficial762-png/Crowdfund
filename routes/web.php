<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminFundraiserController;
use App\Http\Controllers\Admin\AdminFundraiserPostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FundraiserAuthController;
use App\Http\Controllers\FundraiserDashboardController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraiserPostController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/coming-soon', [PageController::class, 'comingSoon'])->name('coming-soon');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact-us');
Route::get('/about-us', [PageController::class, 'about'])->name('about-us');
Route::get('/donate-us/{post?}', [PageController::class, 'donate'])->name('donate-us');

Route::get('/fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');
Route::get('/fundraiser-posts', [FundraiserPostController::class, 'index'])->name('fundraiser-posts.index');

Route::get('/start-fundraiser', [FundraiserAuthController::class, 'start'])->name('fundraiser-details');
Route::get('/fundraiser/login', [FundraiserAuthController::class, 'showLogin'])->name('fundraiser.login');
Route::post('/fundraiser/login', [FundraiserAuthController::class, 'login'])->name('fundraiser.login.submit');
Route::post('/fundraiser/register', [FundraiserAuthController::class, 'register'])->name('fundraiser.register.submit');
Route::post('/fundraiser/logout', [FundraiserAuthController::class, 'logout'])->name('fundraiser.logout');

Route::prefix('fundraiser')->name('fundraiser.')->middleware('fundraiser.approved')->group(function () {
    Route::get('/dashboard', [FundraiserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts', [FundraiserPostController::class, 'myPosts'])->name('posts.index');
    Route::get('/posts/create', [FundraiserPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [FundraiserPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [FundraiserPostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [FundraiserPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [FundraiserPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [FundraiserPostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.dashboard');

Route::get('/admin/fundraiser-profiles', [AdminFundraiserController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.index');

Route::patch('/admin/fundraiser-profiles/{fundraiser}/approve', [AdminFundraiserController::class, 'approve'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.approve');

Route::patch('/admin/fundraiser-profiles/{fundraiser}/reject', [AdminFundraiserController::class, 'reject'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.reject');

Route::get('/admin/fundraiser-posts', [AdminFundraiserPostController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.index');

Route::patch('/admin/fundraiser-posts/{post}/approve', [AdminFundraiserPostController::class, 'approve'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.approve');

Route::patch('/admin/fundraiser-posts/{post}/reject', [AdminFundraiserPostController::class, 'reject'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.reject');
