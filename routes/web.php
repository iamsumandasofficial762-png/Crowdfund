<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminFundraiserPostController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FundraiserController as AdminFundraiserController;
use App\Http\Controllers\Admin\FundraiserReferralController as AdminFundraiserReferralController;
use App\Http\Controllers\Admin\FundraiserReportController as AdminFundraiserReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
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
Route::post('/donate/start', [DonationController::class, 'captureAmount'])->name('donations.capture-amount');
Route::get('/donate/campaigns', [DonationController::class, 'campaigns'])->name('donations.campaigns');
Route::get('/donate-us/{post?}', [PageController::class, 'donate'])->name('donate-us');
Route::post('/donate-us/{post}/donations', [DonationController::class, 'store'])->name('donations.store');
Route::post('/donate-us/{post}/payment-details', [DonationController::class, 'storePaymentDetails'])->name('donations.payment-details.store');
Route::post('/donate-us/{post}/reports', [FundraiserReportController::class, 'store'])->name('fundraiser-reports.store');
Route::post('/site-reports', [SiteReportController::class, 'store'])->name('site-reports.store');
Route::post('/fundraiser-referrals/{post?}', [FundraiserReferralController::class, 'store'])->name('fundraiser-referrals.store');

Route::get('/fundraisers', [FundraiserController::class, 'index'])->name('fundraisers.index');
Route::get('/fundraiser-posts', [FundraiserPostController::class, 'index'])->name('fundraiser-posts.index');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

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
Route::post('/admin', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.dashboard');

Route::get('/admin/activities', [AdminActivityController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.activities.index');

Route::get('/admin/activities/latest', [AdminActivityController::class, 'latest'])
    ->middleware('jwt.session')
    ->name('admin.activities.latest');

Route::post('/admin/activities/{id}/read', [AdminActivityController::class, 'markAsRead'])
    ->middleware('jwt.session')
    ->name('admin.activities.read');

Route::delete('/admin/activities/{id}', [AdminActivityController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.activities.destroy');

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

Route::patch('/admin/reports/{id}/status', [AdminFundraiserReportController::class, 'updateStatus'])
    ->middleware('jwt.session')
    ->name('admin.reports.status');

Route::get('/admin/donations', [AdminDonationController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.donations.index');

Route::get('/admin/fundraisers', [AdminFundraiserController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.index');

Route::patch('/admin/fundraisers/{fundraiser}/approve', [AdminFundraiserController::class, 'approve'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.approve');

Route::patch('/admin/fundraisers/{fundraiser}/hold', [AdminFundraiserController::class, 'hold'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.hold');

Route::patch('/admin/fundraisers/{fundraiser}/reject', [AdminFundraiserController::class, 'reject'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.reject');

Route::get('/admin/fundraisers/{fundraiser}', [AdminFundraiserController::class, 'show'])
    ->middleware('jwt.session')
    ->name('admin.fundraisers.show');

Route::get('/admin/supporters', [AdminFundraiserController::class, 'legacySupporters'])
    ->middleware('jwt.session')
    ->name('admin.supporters.index');

Route::get('/admin/settings', [AdminSettingsController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.settings.index');

Route::get('/admin/users', [AdminUserManagementController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.users.index');

Route::post('/admin/users', [AdminUserManagementController::class, 'store'])
    ->middleware('jwt.session')
    ->name('admin.users.store');

Route::put('/admin/users/{user}', [AdminUserManagementController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.users.update');

Route::patch('/admin/users/{user}/hold', [AdminUserManagementController::class, 'hold'])
    ->middleware('jwt.session')
    ->name('admin.users.hold');

Route::patch('/admin/users/{user}/activate', [AdminUserManagementController::class, 'activate'])
    ->middleware('jwt.session')
    ->name('admin.users.activate');

Route::delete('/admin/users/{user}', [AdminUserManagementController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.users.destroy');

Route::patch('/admin/users/{id}/restore', [AdminUserManagementController::class, 'restore'])
    ->middleware('jwt.session')
    ->name('admin.users.restore');

Route::get('/admin/blogs', [AdminBlogController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.blogs.index');

Route::get('/admin/blog-categories', [AdminBlogCategoryController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.blog-categories.index');

Route::post('/admin/blog-categories', [AdminBlogCategoryController::class, 'store'])
    ->middleware('jwt.session')
    ->name('admin.blog-categories.store');

Route::get('/admin/blog-categories/{blogCategory}/edit', [AdminBlogCategoryController::class, 'edit'])
    ->middleware('jwt.session')
    ->name('admin.blog-categories.edit');

Route::put('/admin/blog-categories/{blogCategory}', [AdminBlogCategoryController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.blog-categories.update');

Route::delete('/admin/blog-categories/{blogCategory}', [AdminBlogCategoryController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.blog-categories.destroy');

Route::get('/admin/events', [AdminEventController::class, 'index'])
    ->middleware('jwt.session')
    ->name('admin.events.index');

Route::get('/admin/events/create', [AdminEventController::class, 'create'])
    ->middleware('jwt.session')
    ->name('admin.events.create');

Route::post('/admin/events/store', [AdminEventController::class, 'store'])
    ->middleware('jwt.session')
    ->name('admin.events.store');

Route::get('/admin/events/{event}/edit', [AdminEventController::class, 'edit'])
    ->middleware('jwt.session')
    ->name('admin.events.edit');

Route::put('/admin/events/{event}/update', [AdminEventController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.events.update');

Route::post('/admin/events/{event}/update', [AdminEventController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.events.update.post');

Route::delete('/admin/events/{event}/delete', [AdminEventController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.events.destroy');

Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])
    ->middleware('jwt.session')
    ->name('admin.blogs.create');

Route::post('/admin/blogs/store', [AdminBlogController::class, 'store'])
    ->middleware('jwt.session')
    ->name('admin.blogs.store');

Route::get('/admin/blogs/{blog}/edit', [AdminBlogController::class, 'edit'])
    ->middleware('jwt.session')
    ->name('admin.blogs.edit');

Route::put('/admin/blogs/{blog}/update', [AdminBlogController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.blogs.update');

Route::post('/admin/blogs/{blog}/update', [AdminBlogController::class, 'update'])
    ->middleware('jwt.session')
    ->name('admin.blogs.update.post');

Route::delete('/admin/blogs/{blog}/delete', [AdminBlogController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.blogs.destroy');

Route::patch('/admin/fundraiser-referrals/{referral}/status', [AdminFundraiserReferralController::class, 'updateStatus'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-referrals.status');

Route::delete('/admin/fundraiser-referrals/{referral}', [AdminFundraiserReferralController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-referrals.destroy');

Route::patch('/admin/fundraiser-posts/{post}/approve', [AdminFundraiserPostController::class, 'approve'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.approve');

Route::patch('/admin/fundraiser-posts/{post}/status', [AdminFundraiserPostController::class, 'updateStatus'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.status');

Route::patch('/admin/fundraiser-posts/{post}/reject', [AdminFundraiserPostController::class, 'reject'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.reject');

Route::patch('/admin/fundraiser-posts/{post}/hold', [AdminFundraiserPostController::class, 'hold'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.hold');

Route::delete('/admin/fundraiser-posts/{post}/delete', [AdminFundraiserPostController::class, 'destroy'])
    ->middleware('jwt.session')
    ->name('admin.fundraiser-posts.destroy');
