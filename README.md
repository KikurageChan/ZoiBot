# ぞいbot

LINE BUSINESS CENTER の Messaging APIを利用して作成しました。  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/zoi_sample.png)

## 機能
このbotはユーザが「ぞい」という言葉をトークルーム内で発言した場合に、画像をランダムで送信するbotです。  
また、botにLINEトークルーム内で「コマンド」としてメッセージを送り、様々な指示を出すことができます。  

## コマンド一覧
|コマンド|機能|
|:--|:--|
|@zoi:save|「反応する言葉」および「返答する言葉」を設定します ※完全一致|
|@zoi:*save|「反応する言葉」および「返答する言葉」を設定します ※部分一致|
|@zoi:list|「反応する言葉」の一覧をメッセージとして表示します ※完全一致|
|@zoi:*list|「反応する言葉」の一覧をメッセージとして表示します ※部分一致|
|@zoi:remove|「反応する言葉」を指定してリストから削除します|
|@zoi:reset|リストから登録した全ての言葉を削除します

### @zoi:save
> - このコマンドはbotに**完全一致**として言葉を覚えさせる時に利用します。  
> - 反応する言葉 -> 返答する言葉 という形でそれぞれ指定します。  
> - 返答する言葉に画像URLを指定することで、画像を返答することも可能です。  
> - 「@」や「:」の記号は半角である必要があります。  

**利用例**  
反応する言葉:あいさつ  
返答する言葉:こんにちは！  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/hello_save.png)

このコマンドで覚えさせた「反応する言葉」は**完全一致**となります。  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/hello_return.png)

---
### @zoi:*save
> - このコマンドはbotに**部分一致**として言葉を覚えさせる時に利用します。  
> - 反応する言葉 -> 返答する言葉 という形でそれぞれ指定します。  
> - 返答する言葉に画像URLを指定することで、画像を返答することも可能です。  
> - 「@」や「:」の記号は半角である必要があります。  
> - 「*」は「＊」でも可能です。

**利用例**  
反応する言葉:リンゴ  
返答する言葉:美味しいです！

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/apple_save.png)

このコマンドで覚えさせた「反応する言葉」は**部分一致**となります。  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/apple_return.png)

---
### @zoi:list
> - このコマンドはbotの完全一致として反応する言葉の一覧を見る時に利用します。  
> - 「@」や「:」の記号は半角である必要があります。  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/list_sample.png)

---
### @zoi:*list
> - このコマンドはbotの部分一致として反応する言葉の一覧を見る時に利用します。  
> - 「@」や「:」の記号は半角である必要があります。  
> - 「*」は「＊」でも可能です。

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/list2_sample.png)

---
### @zoi:remove
> - このコマンドはbotに言葉を忘れさせる時に利用します。  
> - 「@」や「:」の記号は半角である必要があります。  
> - 完全一致 と 部分一致 とを区別する必要はありません。

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/remove_sample.png)

---
### @zoi:reset
> - このコマンドはbotに覚えさせた言葉を全て削除するときに利用します。
> - 現在のバージョンでは、覚える言葉はトークルームごとではなく全て統一として実装しているため、  
> 他のトークルームで動くこのbotにも影響が出てしまいます。利用には注意してください。
> - 「@」や「:」の記号は半角である必要があります。  

![画像](https://github.com/KikurageChan/Zoibot/wiki/images/reset_sample.png)

## 参考
- [NEW GAME](http://newgame-anime.com/)  
- [LINE Developers](https://developers.line.me/bot-api/api-reference)
