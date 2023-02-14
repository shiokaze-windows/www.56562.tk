<?php
const DOC_ROOT='./receive/';
$isContain=false;//ホワイトリストに含まれているか？
/*
ホワイトリストとなるディレクトリを指定
(このディレクトリ以外のファイルはダウンロードさせない)
*/
$dir=opendir(DOC_ROOT);
//ディレクトリの走査
while($file=readdir($dir)){
  if(is_file(DOC_ROOT.$file)){
    $path=DOC_ROOT.$file;//対象となったパスを保存しておく
    //クエリで指定されたファイルがディレクトリにあればOK
    if($_GET['file']===$file){
      //あったのでフラグをtrue
      $isContain=true;
      //抜ける
      break;
    }
  }
}
closedir($dir);//dirを閉じる
//クエリで渡されたファイル名が不正だったら終了
if(!$isContain){
  die('不正なパスが指定されました。');
}
//ファイルを削除
unlink($path);
//listにリダイレクト
header('location:http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/list.php');