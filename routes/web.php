<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'cache.headers:no_store;no_cache;must_revalidate;max_age=0',
])->group(static function (): void {
    Route::view('/', 'home')->name('home');

    Route::controller(LoginController::class)
        ->prefix('/auth')
        ->group(static function (): void {
            Route::get('/login', 'showForm')->middleware('guest')->name('login');
            Route::post('/login', 'authenticate')->middleware('guest')->name('authentication');
            Route::post('/logout', 'logout')->middleware('auth')->name('logout');
        });

    Route::controller(ItemController::class)
        ->prefix('/items')
        ->name('items.')
        ->group(static function (): void {
            Route::get('', 'list')->name('list');
            Route::get('/create', 'showCreateForm')->middleware('auth')->name('create-form');
            Route::post('', 'create')->middleware('auth')->name('create');
            Route::get('/{item}', 'view')->whereNumber('item')->name('view');

            Route::middleware(['auth'])
                ->prefix('/{item}')
                ->whereNumber('item')
                ->group(static function (): void {
                    Route::post('', 'update')->name('update');
                    Route::get('/update', 'showUpdateForm')->name('update-form');
                    Route::post('/delete', 'delete')->name('delete');
                });
        });

    Route::controller(CategoryController::class)
        ->prefix('/categories')
        ->name('categories.')
        ->group(static function (): void {
            Route::get('', 'list')->name('list');
            Route::get('/create', 'showCreateForm')->middleware('auth')->name('create-form');
            Route::post('', 'create')->middleware('auth')->name('create');
            Route::get('/{category}', 'view')->whereNumber('category')->name('view');

            Route::middleware(['auth'])
                ->prefix('/{category}')
                ->whereNumber('category')
                ->group(static function (): void {
                    Route::post('', 'update')->name('update');
                    Route::get('/update', 'showUpdateForm')->name('update-form');
                    Route::post('/delete', 'delete')->name('delete');
                });
        });

    Route::controller(SupplierController::class)
        ->prefix('/suppliers')
        ->name('suppliers.')
        ->middleware(['auth'])
        ->group(static function (): void {
            Route::get('', 'list')->name('list');
            Route::get('/create', 'showCreateForm')->name('create-form');
            Route::post('', 'create')->name('create');
            Route::get('/{supplier}', 'view')->whereNumber('supplier')->name('view');

            Route::prefix('/{supplier}')
                ->whereNumber('supplier')
                ->group(static function (): void {
                    Route::post('', 'update')->name('update');
                    Route::get('/update', 'showUpdateForm')->name('update-form');
                    Route::post('/delete', 'delete')->name('delete');
                });
        });

    Route::controller(ReportController::class)
        ->prefix('/reports')
        ->name('reports.')
        ->middleware(['auth'])
        ->group(static function (): void {
            Route::get('/low-stock', 'lowStock')->name('low-stock');
            Route::get('/low-stock/pdf', 'lowStockPdf')->name('low-stock.pdf');
        });
});
