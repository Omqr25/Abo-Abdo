<?php

use App\Http\Controllers\API\ClassificationController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\InvoiceItemController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\MediaController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::get('/',function(){
    return 'hello from api';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ClassificationController::class)->prefix('classifications')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::controller(GroupController::class)->prefix('groups')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::controller(ItemController::class)->prefix('items')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::controller(InvoiceController::class)->prefix('invoices')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::controller(InvoiceItemController::class)->prefix('invoiceitems')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('show_deleted', 'showDeleted');
    Route::post('restore', 'restore');
});

Route::apiResources([ 
    'classifications' => ClassificationController::class,
    'groups' => GroupController::class,
    'items' => ItemController::class,
    'media' => MediaController::class,
    'invoices' => InvoiceController::class,
    'invoiceitems' => InvoiceItemController::class,
    'expenses' => ExpenseController::class,
    'employees' => EmployeeController::class,
    'users' => UserController::class,
]);
