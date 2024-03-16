<?php

use App\Http\Controllers\Customer\WelcomeController as CustomerWelcomeController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;

use App\Models\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::name('customer.')->group(function () {
    Route::get('/', [CustomerWelcomeController::class, 'index'])->name('welcome.index');
});

Route::get('/forge/login/{id?}', function (Request $request) {
    $user = User::find($request->id);
    auth()->loginUsingId($user->id);
});

// Route::get('/test', function () {
//     return redirect('/')->with('flash', [
//         'sweetTitle' => 'ขอแสดงความเสียใจ',
//         'sweetMessage' => 'ไม่สามารถชำระเงินได้ ณ ขนาดนี้',
//         'sweetStyle' => 'error',
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/redirects', function () {
        if ($user = auth()->user()) {
            $role = $user->role;
            if ($role == 0) {
                return redirect()->route('customer.dashboard.index');
            }
            if ($role == 1) {
                return redirect()->route('admin.dashboard.index');
            }
            if ($role == 2) {
                return redirect()->route('owner.dashboard.index');
            }
        }
    });

    Route::prefix('customer')->name('customer.')->middleware('customer')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard.index');
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    });

    Route::prefix('owner')->name('owner.')->middleware('owner')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard.index');
    });
});
