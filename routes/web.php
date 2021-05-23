<?php

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



Route::get('/books', function () {
    $books = Book::orderBy('created_at', 'desc')->get();
    return view('books.index', compact('books'));
})->middleware(['auth'])->name('books');

// 本を追加
Route::post('/books', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'item_name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $books = new Book;
    $books->item_name = $request->item_name;
    $books->item_number = '1';
    $books->item_amount = '1000';
    $books->published = '2017-03-07 00:00:00';
    $books->save();

    return redirect(route('books'));
})
    ->middleware(['auth'])->name('books.create');

// 本を削除
Route::delete('/book/{book}', function (Book $book) {
    $book->delete();
    return redirect(route('books'));
})->middleware(['auth']);
