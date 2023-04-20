# RUMISESSION
___
[Click here to English readme](./README_EN.md)
## るみせっしょんってな～に？
「るみせっしょん」は、PHPで作成されたセッションライブラリです。<BR>
るみさーばー専用に開発したものを、OSSにして公開したものです。<BR>

## 使い方
まずはnew RUMISESSION()をしましょう！
```php
$RUMISESSION = new RUMISESSION();
```
したらばPHPでいう「session_start()」みたいなのをしましょう！
```php
$RUMISESSION->RSESSION_START();
```
これで準備おㅋ！
### 値をセットする
以下のようにすると、値をセットできます。
```php
$RUMISESSION->RSESSION_SET("値の名前", "値");
```
値の名前には、好きなものをどうぞ、セッションなら「SESSION」とかね。
### 値を取得する
以下のようにすると、返り値として習得できます。
```php
$RUMISESSION->RSESSION_GET("値の名前");
```
### 値を削除する
以下のようにすると、値を削除できます。
```php
$RUMISESSION->RSESSION_DEL("値の名前");
```