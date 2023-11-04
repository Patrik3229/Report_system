<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web" middleware group. Enjoy building your web!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User dashboard
    Route::get('/user-dashboard', function () {
        return view('user-dashboard');
    })->name('user.dashboard');
    
    // Reports
    Route::get('/create-report', function () {
        return view('create-report');
    })->name('show.create.report');
    Route::post('/reports', [ReportController::class, 'createAReport'])->name('create.report');
    Route::get('/my-reports', [ReportController::class, 'showMyReports'])->name('my.reports');
    Route::get('/report/{report}', [ReportController::class, 'viewAReport'])->name('report.view');

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Admin dashboard
        Route::get('/admin-dashboard', function () {
            return view('admin-dashboard');
        })->name('admin.dashboard');

        // Report management
        Route::get('/handle-reports', [ReportController::class, 'showReports'])->name('handle.reports');
        Route::post('/report/{report}/claim', [ReportController::class, 'claimAReport'])->name('report.claim');
        Route::post('/report/{report}/unclaim', [ReportController::class, 'unclaimAReport'])->name('report.unclaim');
        Route::post('/report/{report}/accept', [ReportController::class, 'acceptReport'])->name('report.accept');
        Route::post('/report/{report}/decline', [ReportController::class, 'declineReport'])->name('report.decline');
        Route::post('/report/{report}/handle', [ReportController::class, 'handleReport'])->name('report.handle');
    });

    // Invalid claim method route (not protected by 'admin' middleware)
    Route::get('/report/{id}/claim', function() {
        return redirect('/handle-reports')->with('error', 'Invalid access method.');
    });
});

// Auth routes
require __DIR__.'/auth.php';
