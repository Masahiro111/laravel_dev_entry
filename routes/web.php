<?php

use App\Http\Controllers\BooksController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


Route::get('/books', [BooksController::class, 'index'])
    ->middleware(['auth'])
    ->name('books');

// 本を追加
Route::post('/books', [BooksController::class, 'store'])
    ->middleware(['auth'])
    ->name('books.create');

// 更新画面
Route::get('/bookedit/{book}', [BooksController::class, 'edit']);

// 更新処理
Route::post('/books/update', [BooksController::class, 'update'])
    ->middleware(['auth'])
    ->name('book.update');

// 本を削除
Route::delete('/book/{book}', [BooksController::class, 'delete'])
    ->middleware(['auth']);
