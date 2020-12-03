<?php

// ファイルの指定
$dataFile = 'datafile.dat';

//エスケープする関数
function h($s){
return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

//name="send_message"のPOST送信があった時
if(isset($_POST["send_message"])){
    //送信されたname="message"とname="user_name"の値を取得する
    $message = trim($_POST['message']);
    $user = trim($_POST['user_name']);

    //messageが空じゃなかったら
    if(!empty($message)){

        //userが空の場合、名無しにする
        if(empty($user)){
          $user = "名無し";
        }
        //日付を取得する
        $postDate = date('Y-m-d H:i:s');
        //ファイルに書き込むメッセージを作成する
        $newData  = $message." \n ".$postDate." / ".$user."\n";
        //ファイルを開く
        $fp = fopen($dataFile,'a');
        //ファイルに書き込む
        fwrite($fp,$newData);
        //ファイルを閉じる
        fclose($fp);
    }
}
//一行ずつデータを取り出して配列に入れる
$post_list = file($dataFile,FILE_IGNORE_NEW_LINES);
//逆順に並べ替える
$post_list = array_reverse($post_list);


?>
<!DOCTYPE html>
<html>
<head lang="ja">
<meta charset="utf-8">
<link href="ke.css" rel="stylesheet" type="text/css" media="all">
<title>掲示板</title>
<link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="favicon.ico" sizes="76x76">
<link rel="icon" href="favicon.ico" sizes="96x96">
<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>
<body block='>
    '>
</body>
<body>
    <div class="container">
<h2>自由な掲示板</h2>
<font color="skyblue" size="8"><p id="Clock1" style="display: inline"></p>
<script type="text/javascript">
setInterval('showClock1()',1000);
function showClock1() {
var DWs = new Array('Sun.','Mon.','Tue.','Wed.','Thu.','Fri.','Sat.');
var Now = new Date();
var YY = Now.getYear();
if (YY < 2000) { YY += 1900; }
var MM = set0( Now.getMonth() + 1 );
var DD = set0( Now.getDate() );
var DW = DWs[ Now.getDay() ];
var hh = set0( Now.getHours() );
var mm = set0( Now.getMinutes() );
var ss = set0( Now.getSeconds() );
var RTime1 = ' ' + YY + '.' + MM + '.' + DD + ' ' + DW + ' ' + hh + ':' + mm + ':' + ss + ' ';
document.getElementById("Clock1").innerHTML = RTime1;
}
function set0(num) {
var ret;
if( num < 10 ) { ret = "0" + num; }
else { ret = num; }
return ret;
}
</script>
</font>
<!--ここで投稿内容を送信する-->
<form action="" method="post">
    メッセージ<br><textarea type="text" name="message"></textarea><br>
    ユーザー名<br><input type="text" name="user_name">
    <input style="width:100%;padding:20px;font-size:23px;" type="submit" name="send_message" value="投稿">
</form>
<h2>投稿一覧</h2>
<font size="5">
<ul>
<!--post_listがある場合-->
<?php if (!empty($post_list)){ ?>
    <!--post_listの中身をひとつづつ取り出し表示する-->
    <?php foreach ($post_list as $post){ ?>
    <ul><?php echo h($post); ?></ul>
    <?php } ?>
<?php }else { ?>
    <ul>まだ投稿はありません。</ul>
<?php } ?>
</ul>
</body>
</html>

