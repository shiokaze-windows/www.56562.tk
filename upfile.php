<title>ファイルアップローダー</title>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="/56562.png">
  <style>
    body {
      font-family: Arial, sans-serif;
      color: white;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 50px auto;
      text-align: left;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }

    input[type="text"],
    input[type="file"],
    input[type="submit"] {
      padding: 10px 20px;
      margin: 20px 0;
      font-size: 16px;
      border-radius: 5px;
      border: none;
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
    }

    input[type="submit"] {
      background-color: #1D9BF0;
      cursor: pointer;
    }

    a {
      color: #1D9BF0;
      text-decoration: none;
      margin-top: 20px;
      display: inline-block;
    }

    h2 {
      color: #1D9BF0;
      margin-top: 50px;
    }
  </style>
</head>
<body link="#1D9BF0" alink="#1D9BF0" vlink="#1D9BF0" style="background-color: rgb(21, 32, 43);">
  <?php
  // Get the date and time and adjust with UTC
  $hour = date('H');
  $date = date('d');
  if ($hour > 23) {
    $date += 1;
    $hour -= 24;
  }
	if (!strlen($_COOKIE['username'])) {
        $_COOKIE['username'] = "名無し";
 }
  // Set error display
  ini_set("display_errors", "Off");

  // Display the upload form
  echo '<form action="./upfile.php" method="POST" enctype="multipart/form-data">';
  echo '<span>名前 </span><input type="text" size="10" autocomplete="name" name="name" value="';
echo $_COOKIE['username'];
echo '"><span> </span><input type="file" name="file" required>';
echo '<input type="submit" value="ファイルをアップロードする"></form>';

//今日の日付・時刻
$todaydate = date('n') . "/" . $date . "/" . $hour . ":" . date('i') . ":" . date('s');

//現在のアップロード数の取得
$fp = fopen('./count.txt', "r");
$count = fgets($fp);

//ファイルアップロード
try{
if(is_uploaded_file($_FILES['file']['tmp_name'])){
//拡張子を取得
$filetype = ".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//アップロード
move_uploaded_file($_FILES['file']['tmp_name'], './receive/'.$count.$filetype);
echo "<p>"."./receive/".$count.$filetype."として保存されました"."</p>";
echo '<h2>UP完了</h2>';
		//ログに記録
        $putting='<p><span style="color:yellow">'.$_COOKIE['username'].'さんが</span><a style="color:yellow" href="'."./receive/".$count.$filetype.'"target="_blank" rel="noopener noreferrer">ファイル</a><span style="color:yellow">をUPしました。'."  ".$todaydate.'</span>'."</p>"."\n";
        $count++;
		$filename = fopen('./date/publiclog.txt',"a");
		fputs($filename, $putting);
		fclose($filename);
		
		//アップロード数を更新
		$filename = './count.txt';
		$fp = fopen($filename, 'w');
			$data = $count;
			fputs($fp, $data);
			fclose($fp);
		}
}catch(Exception $e) {
        echo 'エラー:', $e->getMessage().PHP_EOL;
}
//研究対象コード
//何故動いた...w
?>
<a href="./pchat.php" style="text-decoration:none">チャットに戻る</a>
</body>