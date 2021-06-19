<?php

namespace App\Http\Controllers;

use App\Library\MarkParser;
use App\Library\Markup\MarkupExtension;
use App\Library\TwitterHandleParser;
use ElGigi\CommonMarkEmoji\EmojiExtension;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use SimonVomEyser\CommonMarkExtension\LazyImageExtension;

class MarktestController extends Controller
{

        public function index(Request $request)
        {
                $this->environment = Environment::createGFMEnvironment();
                $this->environment->addInlineParser(new MarkParser());
                $this->environment->addExtension(new LazyImageExtension());
                $this->environment->addExtension(new EmojiExtension());
                $this->environment->addExtension(new AttributesExtension());
                $this->environment->addExtension(new FootnoteExtension());
                $this->environment->addExtension(new MarkupExtension());

                $this->environment->addInlineParser(new TwitterHandleParser());

                $converter = new GithubFlavoredMarkdownConverter([
                        'html_input' => 'escape',
                        'allow_unsafe_links' => 'false',
                ], $this->environment);

                $mark_to_html = $converter->convertToHtml('
e>> data <<

Duis mollis, est non commodo luctus, nisi erat porttitor ligula[^note1], eget lacinia odio.

[^note1]: Elit Malesuada Ridiculus

フォローよろ @masahiro111

<b>aaa</b>

<a href="#">hash</a>

this is *green*{style="color: red"}

https://google.com

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


                return view('books.mark_index', compact('mark_to_html'));
        }
}
