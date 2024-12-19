<?php

use App\Http\Controllers\API\AdditionalController;
use App\Http\Controllers\API\ClassificationController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\ReportsController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::get('/', function () {
    return 'hello from api';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ClassificationController::class)->prefix('classifications')->group(function () {
        Route::get('getgroups', 'getGroups')->withoutMiddleware('auth:sanctum')->name('classifications.getgroups');
        Route::get('', 'index')->withoutMiddleware('auth:sanctum');
        Route::get('/{id}', 'show')->withoutMiddleware('auth:sanctum');
        Route::post('', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
    });

    Route::controller(GroupController::class)->prefix('groups')->group(function () {
        Route::get('', 'index')->withoutMiddleware('auth:sanctum')->name('groups.index');
        Route::get('/{id}', 'show')->withoutMiddleware('auth:sanctum');
        Route::post('', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
    });

    Route::controller(ItemController::class)->prefix('items')->group(function () {
        Route::get('', 'index')->withoutMiddleware('auth:sanctum');
        Route::get('/{id}', 'show')->withoutMiddleware('auth:sanctum');
        Route::post('', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
    });

    Route::controller(MediaController::class)->prefix('media')->group(function () {
        Route::get('index/{group}', 'index');
        Route::get('show/{name}', 'show');
        Route::post('upload', 'upload');
        Route::post('delete', 'delete');
    });

    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
        Route::get('getgroups/{customer_id}', 'getGroups');
    });

    Route::controller(InvoiceController::class)->prefix('invoices')->group(function () {
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
    });
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('show_deleted', 'showDeleted');
        Route::post('restore', 'restore');
    });

    Route::controller(ExpenseController::class)->prefix('expenses')->group(function () {
        Route::get('getExpenseDetails/{type}/{date}', 'getExpenseDetails')->name('ExpensesDetails');
        Route::get('getall/{type}', 'getAll');
    });

    Route::controller(ReportsController::class)->prefix('reports')->group(function () {
        Route::get('lastyearearnings', 'LastYearEarnings');
        Route::get('monthlyreport/{month}/{year}', 'MonthlyReport');
    });

    Route::apiResources([
        'customers' => CustomerController::class,
        'invoices' => InvoiceController::class,
        'expenses' => ExpenseController::class,
        'employees' => EmployeeController::class,
        'users' => UserController::class,
        'additionals' => AdditionalController::class
    ]);
});
