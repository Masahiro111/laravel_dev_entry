<?php

use App\Models\Book;
use Illuminate\Http\Request;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/books', function () {
    return view('books.index');
})->middleware(['auth'])->name('books');

// 本を追加
Route::post('/books', function (Request $request) {
    return view('books.index');
})->middleware(['auth']);

// 本を削除
Route::delete('/book/{book}', function (Book $book) {
    //
})->middleware(['auth']);
