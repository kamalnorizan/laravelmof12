<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueTutorialController;

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware(['auth']);

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/invoices/{invoice}', [InvoiceController::class, 'payinvoice'])->name('invoices.payinvoice');
Route::get('/invoices/{invoice}/redirect', [InvoiceController::class, 'redirect'])->name('invoice.redirect');
Route::get('/invoices/{invoice}/callback', [InvoiceController::class, 'callback'])->name('invoice.callback');


Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware(['auth','permission:view users']);
Route::get('/users/print', [UserController::class, 'print'])->name('users.print')->middleware(['auth','permission:view users']);
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware(['auth','permission:create users']);
Route::post('/users/ajaxloadusers', [UserController::class, 'ajaxloadusers'])->name('users.ajaxloadusers')->middleware(['auth','permission:view users']);
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware(['auth','permission:edit users']);
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['auth','permission:edit users']);
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware(['auth','permission:view users']);

Route::get('/testmail', [QueueTutorialController::class, 'testmail'])->name('tutorial.testmail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
