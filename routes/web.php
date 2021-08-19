<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::match(['GET', 'POST'], '/register', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ajax/categories/search', [CategoryController::class, 'ajaxSearch'])->name('ajax.search');

Route::get('/categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('/categories/{category}/delete-permanent', [CategoryController::class, 'deletePermanent'])->name('categories.delete-permanent');

Route::get('/books/trash', [BookController::class, 'trash'])->name('books.trash');
Route::post('books/{book}/restore', [BookController::class, 'restore'])->name('books.restore');
Route::delete('/books/{id}/delete-permanent', [BookController::class, 'deletePermanent'])->name('books.delete-permanent');

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
