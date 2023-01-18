<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

//    Route::group(['prefix' => 'register'], function (){
//        Route::get('/', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
//        Route::post('/', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
//    });
    Route::group(['prefix' => 'login'], function (){
        Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    });
    Route::group(['as' => 'password.'], function (){
        Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('request');
        Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('email');
        Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('reset');
        Route::post('reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('update');
    });
});

Route::middleware(['auth'])->group(function (){
    Route::group(['prefix' => 'app', 'as' => 'app.'], function (){
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');

        Route::resource('report', \App\Http\Controllers\Report\ReportIndexController::class)->only(['index']);
        Route::group(['prefix' => 'report', 'as' => 'report.'], function (){
            Route::resource('transaction', \App\Http\Controllers\Report\ReportDailyTransactionController::class)->only(['index']);
            Route::resource('recap', \App\Http\Controllers\Report\ReportRecapTransactionController::class)->only(['index']);

            Route::resource('asset', \App\Http\Controllers\Report\ReportAssetController::class)->only(['index', 'show']);
            Route::resource('stock', \App\Http\Controllers\Report\ReportStockController::class)->only(['index', 'show', 'edit']);
        });
        Route::resource('inventory', \App\Http\Controllers\Inventory\InventoryController::class)->only(['index']);
        Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function (){
            Route::resource('request', \App\Http\Controllers\Inventory\InventoryRequestController::class)->only(['index', 'store', 'edit', 'destroy', 'show']);
            Route::group(['prefix' => 'request', 'as' => 'request.'], function (){
                Route::group(['prefix' => 'product', 'as' => 'product.'], function (){
                    Route::post('{purchase}/add', [\App\Http\Controllers\Inventory\InventoryRequestController::class, 'add'])->name('add');
                    Route::delete('{purchase}/delete', [\App\Http\Controllers\Inventory\InventoryRequestController::class, 'delete'])->name('delete');
                    Route::patch('{purchase}/update', [\App\Http\Controllers\Inventory\InventoryRequestController::class, 'update'])->name('update');
                    Route::patch('{purchase}/save', [\App\Http\Controllers\Inventory\InventoryRequestController::class, 'save'])->name('save');

                });
            });
            Route::resource('maintenance', \App\Http\Controllers\Inventory\InventoryMaintenanceController::class)->only(['index']);
        });

        Route::group(['prefix' => 'request', 'as' => 'request.'], function (){
            Route::post('supplier', [\App\Http\Controllers\Request\RequestController::class, 'supplier'])->name('get.supplier');
            Route::post('product', [\App\Http\Controllers\Request\RequestController::class, 'product'])->name('get.product');

        });
    });

    // Authenticate Route
    Route::group(['as' => 'verification.'], function (){
        Route::get('verify-email/', [\App\Http\Controllers\Auth\EmailVerificationPromptController::class, '__invoke'])->name('notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('send');
    });

    Route::group(['prefix' => 'confirm-password'], function (){
        Route::get('/', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store']);
    });

    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
