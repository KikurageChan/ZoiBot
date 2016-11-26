<!DOCTYPE html>
<html>
<head>
<style>
pre{
    background-color: rgb(200, 200, 200);
}
</style>
<meta charset="UTF-8">
<title>ぞいbot</title>
</head>
<body>
<pre>
<?php
    print('Current PHP version:  ' . phpversion() ."\n");
    $separate = '------------------------------------------';
    print("--------------------完全一致(  ==  )--------------------\n");
    $equal_array = getTalkData('equal.json');
    $talk = "";
    for ($i=0; $i < count($equal_array); $i++) {
        $req = $equal_array[$i]['req'];
        $res = $equal_array[$i]['res'];
        $talk = $talk . "${req}\n\n${res}\n" . "${separate}\n";
    }
    print($talk);
    print("--------------------部分一致(contain)--------------------\n");
    $contain_array = getTalkData('contain.json');
    $talk = "";
    for ($i=0; $i < count($contain_array); $i++) {
        $req = $contain_array[$i]['req'];
        $res = $contain_array[$i]['res'];
        $talk = $talk . "${req}\n\n${res}\n" . "${separate}\n";
    }
    $talk = trim($talk);
    print($talk);
    ?>
</pre>
</body>
</html>
<?php
    $accessToken = '****************************************************************************************************************************************************************************';
    //ユーザーからのメッセージ取得
    $jsonData = file_get_contents('php://input');
    $jsonObj = json_decode($jsonData);
    //メッセージのタイプを取得
    $type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
    //メッセージ取得
    $text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
    //ReplyToken取得
    $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
    
    
    if ($type != "text"){
        exit;
    }
    
    $zois = [
        "https://41.media.tumblr.com/9cdd4f41d96600d13eddac32da17ba79/tumblr_ngga9kcFVX1qd1ozgo1_500.jpg",//ぞいぞい
        "https://40.media.tumblr.com/4656b8918f43f53fcccd9811030525f7/tumblr_nefii3BoOm1qd1ozgo1_500.jpg",//え？ぞい
        "https://67.media.tumblr.com/044137b9dd7823fc26d2a0513fb6a5ef/tumblr_ob2n9hMEfJ1uubj4co1_250.jpg",//ぞいってなんですか
        "https://67.media.tumblr.com/9c2ee93e5fb70bce7f7e0e276019ae18/tumblr_oh8pyeRiPn1vlb9mso1_400.jpg",//ぞい!
    ];
    
    if(strpos($text, "ぞい") !== false){
        $random = rand(0,count($zois) - 1);
        $image = "${zois[$random]}";
        postImage($image);
    }
    if(preg_match("/@zoi:(.?)save/u", $text ,$option)){
        $trimed_text = trim($text);
        $remove_command = preg_replace("/@zoi:(.?)save/u", '', $trimed_text);
        list($one, $two) = explode("->", $remove_command);
        $trimed_one = trim("${one}");
        $trimed_two = trim("${two}");
        //片方でも空文字の場合
        if (empty($trimed_one) || empty($trimed_two)){
            postRandomMessage("あれ？\nよく分かりません","覚えられません...","うまくいきません");
        }
        //コマンド関係の場合
        if(strpos($trimed_one, "@zoi") !== false || strpos($trimed_two, "@zoi") !== false){
            postRandomMessage("あれ？\nよく分かりません","覚えられません...","うまくいきません");
        }
        //「ぞい」の場合
        if($trimed_one == 'ぞい'){
            postMessage("ぞいは譲れません！");
        }
        //もしメッセージがすでに登録してある完全一致と重なった場合
        for ($i=0; $i < count($equal_array); $i++) {
            if($trimed_one == $equal_array[$i]['req']){
                postRandomMessage("もう覚えてますよっ！","すでに覚えてます！","もう覚えてますって！");
            }
        }
        //完全一致で登録してきたとしても、containの方も拒否する必要があります。
        for ($i=0; $i < count($contain_array); $i++) {
            if($trimed_one == $contain_array[$i]['req']){
                postRandomMessage("もう覚えてますよっ！","すでに覚えてます！","もう覚えてますって！");
            }
        }
        //反応する言葉にリンクを利用しようとした場合
        if(strpos($trimed_one, "http") !== false){
            postMessage("URLは反応できません！");
        }
        //http://を返事として保存しようとした場合
        if(preg_match("/^http:\/\//", $trimed_two)){
            postMessage("httpのUTLは\n覚えられないです...");
        }
        //https://を返事として保存しようとし、うまく読み込めない場合
        if (preg_match("/^https:\/\//", $trimed_two)){
            if(!file_get_contents($trimed_two)){
                postMessage("リンクが無効かも\nしれないです...");
            }
        }
        if($option[1] == '*' || $option[1] == '＊'){
            //もしメッセージがすでに登録してある部分一致に含まれていた場合
            for ($i=0; $i < count($contain_array); $i++) {
                //「ぞい」の場合
                if(strpos($trimed_one, 'ぞい') !== false){
                    postMessage("ぞいは譲れません！");
                }
                //反応する言葉にすでに登録されている言葉が含まれているか
                if(strpos($trimed_one, $contain_array[$i]['req']) !== false){
                    postMessage("覚えている言葉の中に\nその言葉が含まれて\nいるので難しいです...");
                }
                if(strpos($contain_array[$i]['req'], $trimed_one) !== false){
                    postMessage("覚えている言葉の中に\nその言葉が含まれて\nいるので難しいです...");
                }
            }
            addTalkData('contain.json',$trimed_one,$trimed_two);
            postRandomMessage("了解です！","覚えておきます！","わかりました！");
        }elseif($option[1] == ''){
            addTalkData('equal.json',$trimed_one,$trimed_two);
            postRandomMessage("了解です！","覚えておきます！","わかりました！");
        }
        postRandomMessage("あれ？\nよく分かりません","覚えられません...","うまくいきません");
    }
    if($text == "@zoi:*list" || $text == "@zoi:＊list"){
        if(empty($contain_array)){
            $message = "わたしはまだ\n何も覚えていません\nぜひ 教えてください！";
            postMessage($message);
        }
        $separate = '---------------------';
        $message = "わたしは以下の\n言葉が含まれていたら\n反応するよ！！\n${separate}\n";
        for ($i=0; $i < count($contain_array); $i++) {
            $message = $message . $contain_array[$i]['req'] . "\n${separate}\n";
        }
        $message = trim("${message}");
        postMessage($message);
    }
    if($text == "@zoi:list"){
        if(empty($equal_array)){
            $message = "わたしはまだ\n何も覚えていません\nぜひ 教えてください！";
            postMessage($message);
        }
        $separate = '---------------------';
        $message = "わたしは以下の\n言葉と一致したら\n反応するよ！！\n${separate}\n";
        for ($i=0; $i < count($equal_array); $i++) {
            $message = $message . $equal_array[$i]['req'] . "\n${separate}\n";
        }
        $message = trim("${message}");
        postMessage($message);
    }
    if(strpos($text, "@zoi:remove") !== false){
        $trimed_text = trim($text);
        $remove_command = str_replace('@zoi:remove', '', $trimed_text);
        $remove_command_trimed = trim($remove_command);
        for ($i=0; $i < count($equal_array); $i++) {
            $q = $equal_array[$i]['req'];
            if($q == $remove_command_trimed){
                array_splice($equal_array,$i,1);
                $json = json_encode($equal_array,JSON_UNESCAPED_UNICODE);
                file_put_contents("equal.json", $json, LOCK_EX);
                $message = "「${remove_command_trimed}」\nを忘れます！";
                postMessage($message);
            }
        }
        for ($i=0; $i < count($contain_array); $i++) {
            $q = $contain_array[$i]['req'];
            if($q == $remove_command_trimed){
                array_splice($contain_array,$i,1);
                $json = json_encode($contain_array,JSON_UNESCAPED_UNICODE);
                file_put_contents("contain.json", $json, LOCK_EX);
                $message = "「${remove_command_trimed}」\nを忘れます！";
                postMessage($message);
            }
        }
        $message = "その言葉、\nもともと覚えてません";
        postMessage($message);
    }
    if($text == "@zoi:reset"){
        $message = "全部忘れちゃいます！";
        removeAllTalkData();
        postMessage($message);
    }
    if($text == "@zoi:print"){
        $message = "equal.jsonを読み込み\n";
        $equal_data = file_get_contents('equal.json');
        $message = $message . "${equal_data}\n";
        $contain_data = file_get_contents('contain.json');
        $message = $message . "contain.jsonを読み込み\n";
        $message = $message . "${contain_data}";
        $message = trim("${message}");
        postMessage($message);
    }
    //ユーザの登録したメッセージを探索
    //完全一致
    for ($i=0; $i < count($equal_array); $i++) {
        if($text == $equal_array[$i]['req']){
            if(strpos($equal_array[$i]['res'], "https://") !== false){
                $img = $equal_array[$i]['res'];
                postImage($img);
            }else{
                postMessage($equal_array[$i]['res']);
            }
        }
    }
    //部分一致
    for ($i=0; $i < count($contain_array); $i++) {
        if(strpos($text, $contain_array[$i]['req']) !== false){
            if(strpos($contain_array[$i]['res'], "https://") !== false){
                $img = $contain_array[$i]['res'];
                postImage($img);
            }else{
                postMessage($contain_array[$i]['res']);
            }
        }
    }
    
    //.jsonファイルからArrayを取得
    function getTalkData($fileName){
        $file = file_get_contents($fileName);
        $array = json_decode($file, true);
        return $array;
    }
    
    //talkデータを.jsonファイルに追加
    function addTalkData($fileName,$req,$res){
        $array = getTalkData($fileName);
        $talk = [];
        $talk["req"] = "${req}";
        $talk["res"] = "${res}";
        $array[] = $talk;
        $json = json_encode($array,JSON_UNESCAPED_UNICODE);
        file_put_contents($fileName, $json, LOCK_EX);
    }
    
    //.jsonの中身をすべて削除
    function removeAllTalkData(){
        file_put_contents("equal.json", '', LOCK_EX);
        file_put_contents("contain.json", '', LOCK_EX);
    }
    
    //引数に渡したテキストからランダムでメッセージを送ります
    function postRandomMessage($message){
        $replies = [];
        $random = rand(0,func_num_args() - 1);
        for ($i=0; $i < func_num_args(); $i++) {
            $replies[] = func_get_arg($i);
        }
        $message = $replies[$random];
        postMessage($message);
    }
    ///////////////////////////////////////////////////
    function postMessage($message){
        global $replyToken;
        $data = [
        "type" => "text",
        "text" => "${message}",
        ];
        $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$data]
        ];
        post($post_data);
    }
    
    function postImage($image){
        global $replyToken;
        $data = [
        "type" => "image",
        "originalContentUrl" => "${image}",
        "previewImageUrl" => "${image}",
        ];
        $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$data]
        ];
        post($post_data);
    }
    
    function post($send_data){
        global $accessToken;
        $json = json_encode($send_data);
        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                   'Content-Type: application/json; charser=UTF-8',
                                                   'Authorization: Bearer ' . $accessToken
                                                   ));
        $result = curl_exec($ch);
        curl_close($ch);
        exit;
    }
?>
