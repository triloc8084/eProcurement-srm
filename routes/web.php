<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProcurementController as AdminProcurementController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\RequestController as UserRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Admin\KnowledgeBaseController as AdminKBController;
use App\Http\Controllers\User\KnowledgeBaseController as UserKBController;

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\User\SupplierController as UserSupplierController;

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/suppliers/export', [ReportController::class, 'exportSuppliers'])->name('reports.suppliers.export');
    Route::get('/reports/procurements/export', [ReportController::class, 'exportProcurements'])->name('reports.procurements.export');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('procurements', AdminProcurementController::class);
    Route::resource('knowledge-base', AdminKBController::class);
    Route::resource('notifications', AdminNotificationController::class)->only(['index', 'create', 'store']);
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/suppliers', [UserSupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplier}', [UserSupplierController::class, 'show'])->name('suppliers.show');

    Route::resource('requests', UserRequestController::class);
    Route::get('knowledge-base', [UserKBController::class, 'index'])->name('knowledge-base.index');
    Route::get('knowledge-base/{knowledgeBase}', [UserKBController::class, 'show'])->name('knowledge-base.show');
    Route::post('requests/{request}/rate', [UserRequestController::class, 'rate'])->name('requests.rate');
    Route::post('requests/{request}/sign', [UserRequestController::class, 'sign'])->name('requests.sign');

    Route::resource('notifications', AdminNotificationController::class)->only(['index', 'create', 'store']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/poll', [\App\Http\Controllers\NotificationController::class, 'poll'])->name('notifications.poll');
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::post('/procurements/{procurement}/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});


require __DIR__.'/auth.php';
