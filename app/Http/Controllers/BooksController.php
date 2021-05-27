<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{

    // 一覧表示
    public function index()
    {
        $books = Book::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('books.index', compact('books'));
    }

    // 登録
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:5',
            'item_amount' => 'required|min:1|max:6',
            'published' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('books'))
                ->withInput()
                ->withErrors($validator);
        }

        $books = new Book;
        $books->user_id = Auth::user()->id;
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();

        return redirect(route('books'))
            ->with('message', '登録が完了しました。');;
    }

    // 更新画面のひょうじ　
    public function edit($book_id)
    {
        $book = Book::where('user_id', Auth::user()->id)->find($book_id);

        return view('books.bookedit', compact('book'));
    }

    // 更新
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:5',
            'item_amount' => 'required|min:1|max:6',
            'published' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/bookedit/' . $request->id)
                ->withInput()
                ->withErrors($validator);
        }

        $books = Book::where('user_id', Auth::user()->id)
            ->find($request->id);
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();

        return redirect(route('books'))
            ->with('message', '更新が完了しました。');
    }

    // 削除
    public function delete(Book $book)
    {
        $book->delete();
        return redirect(route('books'));
    }
}
