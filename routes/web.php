<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminFundraiserPostController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\FundraiserReferralController as AdminFundraiserReferralController;
use App\Http\Controllers\Admin\FundraiserReportController as AdminFundraiserReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\SupporterController as AdminSupporterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FundraiserAuthController;
use App\Http\Controllers\FundraiserDashboardController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraiserPostController;
use App\Http\Controllers\FundraiserPostUpdateController;
use App\Http\Controllers\FundraiserReferralController;
use App\Http\Controllers\FundraiserReportController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteReportController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/coming-soon', [PageController::class, 'comingSoon'])->name('coming-soon');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact-us');
Route::post('/contact-us', [ContactMessageController::class, 'store'])->name('contact-messages.store');
Route::get('/about-us', [PageController::class, 'about'])->name('about-us');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/resource', [PageController::class, 'resource'])->name('resource');
Route::get('/donate-us/{post?}', [PageController::class, 'donate'])->name('donate-us');
Route::post('/donate-us/{post}/donations', [DonationController::class, 'store'])->name('donations.store');
Route::post('/donate-us/{post}/reports', [FundraiserReportController::class, 'store'])->name('fundraiser-reports.store');
Route::post('/site-reports', [SiteReportController::class, 'store'])->name('site-reports.store');
Route::post('/fundraiser-referrals/{post?}', [FundraiserReferralController::class, 'store'])->name('fundraiser-referrals.store');

Route::get('/fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');
Route::get('/fundraiser-posts', [FundraiserPostController::class, 'index'])->name('fundraiser-posts.index');

Route::get('/start-fundraiser', [FundraiserAuthController::class, 'start'])->name('fundraiser-details');
Route::get('/fundraiser/login', [FundraiserAuthController::class, 'showLogin'])->name('fundraiser.login');
Route::post('/fundraiser/login', [FundraiserAuthController::class, 'login'])->name('fundraiser.login.submit');
Route::post('/fundraiser/register', [FundraiserAuthController::class, 'register'])->name('fundraiser.register.submit');
Route::post('/fundraiser/logout', [FundraiserAuthController::class, 'logout'])->name('fundraiser.logout');

Route::prefix('fundraiser')->name('fundraiser.')->middleware('fundraiser.authenticated')->group(function () {
    Route::get('/dashboard', [FundraiserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/story-updates', [FundraiserPostUpdateController::class, 'campaigns'])->name('updates.campaigns');
    Route::get('/posts', [FundraiserPostController::class, 'myPosts'])->name('posts.index');
    Route::get('/posts/create', [FundraiserPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [FundraiserPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/updates', [FundraiserPostUpdateController::class, 'index'])->name('posts.updates.index');
    Route::get('/posts/{post}/updates/create', [FundraiserPostUpdateController::class, 'create'])->name('posts.updates.create');
    Route::post('/posts/{post}/updates', [FundraiserPostUpdateController::class, 'store'])->name('posts.updates.store');
    Route::get('/posts/{post}/updates/{update}/edit', [FundraiserPostUpdateController::class, 'edit'])->name('posts.updates.edit');
    Route::put('/posts/{post}/updates/{update}', [FundraiserPostUpdateController::class, 'update'])->name('posts.updates.update');
    Route::delete('/posts/{post}/updates/{update}', [FundraiserPostUpdateController::class, 'destroy'])->name('posts.updates.destroy');
    Route::get('/posts/{post}', [FundraiserPostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [FundraiserPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [FundraiserPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [FundraiserPostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/admin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.dashboard');

Route::get('/admin/fundraiser-posts', [AdminFundraiserPostController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.index');

Route::get('/admin/fundraiser-referrals', [AdminFundraiserReferralController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-referrals.index');

Route::get('/admin/contact-messages', [AdminContactMessageController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.contact-messages.index');

Route::get('/admin/fundraiser-reports', [AdminFundraiserReportController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-reports.index');

Route::get('/admin/donations', [AdminDonationController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.donations.index');

Route::get('/admin/supporters', [AdminSupporterController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.supporters.index');

Route::get('/admin/settings', [AdminSettingsController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.settings.index');

Route::patch('/admin/fundraiser-referrals/{referral}/status', [AdminFundraiserReferralController::class, 'updateStatus'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-referrals.status');

Route::delete('/admin/fundraiser-referrals/{referral}', [AdminFundraiserReferralController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-referrals.destroy');

Route::patch('/admin/fundraiser-posts/{post}/approve', [AdminFundraiserPostController::class, 'approve'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.approve');

Route::patch('/admin/fundraiser-posts/{post}/reject', [AdminFundraiserPostController::class, 'reject'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.reject');
