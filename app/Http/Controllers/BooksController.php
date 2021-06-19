<?php

namespace App\Http\Controllers;

use App\Library\TwitterHandleParser;
use App\Library\MarkParser;
use App\Models\Book;
use ElGigi\CommonMarkEmoji\EmojiExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use SimonVomEyser\CommonMarkExtension\LazyImageExtension;

class BooksController extends Controller
{

        // 一覧表示
        public function index(Request $request)
        {

                $books = Book::where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(3);

                $this->environment = Environment::createGFMEnvironment();
                $this->environment->addInlineParser(new MarkParser());
                $this->environment->addExtension(new LazyImageExtension());
                $this->environment->addExtension(new EmojiExtension());

                $this->environment->addInlineParser(new TwitterHandleParser());

                $converter = new GithubFlavoredMarkdownConverter([], $this->environment);

                $mark_to_html = $converter->convertToHtml('

# Hello World!
1. 住みたい町
    1. 鎌倉
    1. 神楽坂
    1. 荻窪
1. 部屋の条件
    1. 騒音
    1. ペット可
    1. 駅から徒歩3分 :+1:


!quiz(group:1, type: radio)[ゲーム市場、もっとも売れたゲーム機は次のどれ？]
- スーパーファミコン
        - bool: false
- ニンテンドースイッチ
        - bool: false
- ニンテンドーDS
        - bool: true
- ファミリーコンピュータ
        - bool: false

>> 幕張メッセの最寄り駅はどの駅名でしょう <<
( ) 幕張本郷駅{{幕張本郷駅はJR東日本の駅}}
(x) 海浜幕張駅{{海浜幕張駅は幕張メッセの最寄り駅になります}}
( ) 幕張駅{{間違えやすいのですが、幕張駅は幕張メッセの最寄り駅にはなりません。この駅から幕張メッセまで徒歩40分ほどかかります}}
( ) 京成幕張駅{{京成幕張駅は京成線の駅です}}

>> Panasonicが発売しているノートＰＣブランドはどれでしょう <<
( ) VAIO{{VAIOはVAIO株式会社から発売されているPCブランドです}}
( ) dynabook{{dynabookは東芝から発売されているＰＣブランドです}}
( ) FMV{{FMVは富士通から発売されているPCブランドです}}
(x) Let\'s note{{Let\'s noteはPanasonicから発売されているPCブランドです}}

>> PHPフレームワークはどれでしょう <<
(x) Laravel{{PHPフレームワークです}}
( ) Ruby on Rails
( ) django
( ) Scala

@masahiro


- 緑茶
        - 普通のお茶です
- 生茶
        - コンビニでも買えます
- 抹茶
        - 京都が有名です
- 無茶
        - 食べ物ではないです

[Q](group:1, qt:radio) お茶なのはどれでしょう
- 緑茶
        - 普通のお茶です
- 生茶
        - コンビニでも買えます
- 抹茶
        - 京都が有名です
- 無茶
        - 食べ物ではないです

[Q](group:1, qt:radio) お茶なのはどれでしょう
- 緑茶
        - 普通のお茶です
- 生茶
        - コンビニでも買えます
- 抹茶
        - 京都が有名です
- 無茶
        - 食べ物ではないです
        

```php:index.php
hello
```

- [ ] foo
- [x] bar
    ');


                return view('books.index', compact('books', 'mark_to_html'));
        }


        //         public function index(Request $request)
        //         {

        //                 $books = Book::where('user_id', Auth::user()->id)
        //                         ->orderBy('created_at', 'desc')
        //                         ->paginate(3);

        //                 $this->environment = Environment::createGFMEnvironment();
        //                 $this->environment->addInlineParser(new MarkParser());
        //                 $this->environment->addExtension(new LazyImageExtension());
        //                 $this->environment->addExtension(new EmojiExtension());

        //                 $this->environment->addInlineParser(new TwitterHandleParser());

        //                 $converter = new GithubFlavoredMarkdownConverter([], $this->environment);

        //                 $mark_to_html = $converter->convertToHtml('

        // # Hello World!
        // 1. 住みたい町
        //     1. 鎌倉
        //     1. 神楽坂
        //     1. 荻窪
        // 1. 部屋の条件
        //     1. 騒音
        //     1. ペット可
        //     1. 駅から徒歩3分 :+1:


        // !quiz(group:1, type: radio)[ゲーム市場、もっとも売れたゲーム機は次のどれ？]
        // - スーパーファミコン
        //         - bool: false
        // - ニンテンドースイッチ
        //         - bool: false
        // - ニンテンドーDS
        //         - bool: true
        // - ファミリーコンピュータ
        //         - bool: false

        // >> 幕張メッセの最寄り駅はどの駅名でしょう <<
        // ( ) 幕張本郷駅{{幕張本郷駅はJR東日本の駅}}
        // (x) 海浜幕張駅{{海浜幕張駅は幕張メッセの最寄り駅になります}}
        // ( ) 幕張駅{{間違えやすいのですが、幕張駅は幕張メッセの最寄り駅にはなりません。この駅から幕張メッセまで徒歩40分ほどかかります}}
        // ( ) 京成幕張駅{{京成幕張駅は京成線の駅です}}

        // >> Panasonicが発売しているノートＰＣブランドはどれでしょう <<
        // ( ) VAIO{{VAIOはVAIO株式会社から発売されているPCブランドです}}
        // ( ) dynabook{{dynabookは東芝から発売されているＰＣブランドです}}
        // ( ) FMV{{FMVは富士通から発売されているPCブランドです}}
        // (x) Let\'s note{{Let\'s noteはPanasonicから発売されているPCブランドです}}

        // >> PHPフレームワークはどれでしょう <<
        // (x) Laravel{{PHPフレームワークです}}
        // ( ) Ruby on Rails
        // ( ) django
        // ( ) Scala

        // @masahiro


        // - 緑茶
        //         - 普通のお茶です
        // - 生茶
        //         - コンビニでも買えます
        // - 抹茶
        //         - 京都が有名です
        // - 無茶
        //         - 食べ物ではないです

        // [Q](group:1, qt:radio) お茶なのはどれでしょう
        // - 緑茶
        //         - 普通のお茶です
        // - 生茶
        //         - コンビニでも買えます
        // - 抹茶
        //         - 京都が有名です
        // - 無茶
        //         - 食べ物ではないです

        // [Q](group:1, qt:radio) お茶なのはどれでしょう
        // - 緑茶
        //         - 普通のお茶です
        // - 生茶
        //         - コンビニでも買えます
        // - 抹茶
        //         - 京都が有名です
        // - 無茶
        //         - 食べ物ではないです


        // ```php:index.php
        // hello
        // ```

        // - [ ] foo
        // - [x] bar
        //     ');


        //                 return view('books.index', compact('books', 'mark_to_html'));
        //         }

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

                $file = $request->file('item_img');
                if (!empty($file)) {
                        $filename = $file->getClientOriginalName();
                        $move = $file->move('../public/storage/uploads', $filename);
                } else {
                        $filename = "";
                }

                $books = new Book;
                $books->user_id = Auth::user()->id;
                $books->item_name = $request->item_name;
                $books->item_number = $request->item_number;
                $books->item_amount = $request->item_amount;
                $books->item_img = $filename;
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
