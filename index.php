<?php

  if (isset($_GET["len"]) && isset($_GET["url"]))
  {
    $fileurl = $_GET["url"];
    $times = $_GET["len"] * 1;
  }
  else
  {
    $fileurl = "https://sample-img.lb-product.com/wp-content/themes/hitchcock/images/10MB.png";
    $times = 5;
  }

  function DownloadContents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return strlen($data);
  }

  function calcFileSize($size)
  {
    $b = 1024;
    $mb = pow($b, 2);
    $gb = pow($b, 3);
    switch(true){
      case $size >= $gb:
        $target = $gb;
        $unit = 'GB';
        break;
      case $size >= $mb:
        $target = $mb;
        $unit = 'MB';
        break;
      default:
        $target = $b;
        $unit = 'KB';
        break;
    }
    $new_size = round($size / $target, 2);
    $file_size = number_format($new_size, 2, '.', ',') . $unit;
    return $file_size;
  }

  $i = 0;
  $traffic = 0;
  $time_start = microtime(true);
  while(true)
  {
    $i++;
    $traffic += DownloadContents($fileurl);
    if ($i == $times)
      break;
  }

  $time = microtime(true) - $time_start;
  $Speed = $traffic * 8 / $time / 1024 / 1024;

?>

<!DOCTYPE html>
<html lang="ja" itemscope="" itemtype="http://schema.org/WebPage" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>サーバーのネットワーク速度</title>
    <meta name="ROBOTS" content="noindex, nofollow">
    <style>a{color:#c71585;position:relative;display:inline-block}a,a:after{transition:.3s}a:after{position:absolute;bottom:0;left:50%;content:'';width:0;height:2px;background-color:#31aae2;transform:translateX(-50%)}a:hover:after{width:100%}</style>
  </head>
  <body style="background-color:#6495ed;color:#080808;overflow-x:hidden;overflow-y:visible;">
    <div align="center" id="home">
      <h2>サーバーのネットワーク速度</h2>
      <hr size="1" color="#7fffd4">
      <h1><?=$Speed?>Mbps</h1>
      <pre>(トラフィック量が100MB以下の場合には、正しい数値にならない可能性があります。)</pre>
      URL(<b><?=htmlspecialchars($fileurl)?></b>)に<br><b><?=$times?>回</b>アクセスした結果、<br>
      <b><?=$time?></b>秒かかり、<br>合計<b><?=$traffic?>バイト(<?=calcFileSize($traffic)?>)</b>のトラフィックが発生しました。</pre>
      <hr size="1" color="#7fffd4">
      <form action="" method="GET">
      ファイルのURL: <input type="text" size="50" name="url" value="https://sample-img.lb-product.com/wp-content/themes/hitchcock/images/10MB.png" placeholder="URL" title="URL"><br>
      アクセス回数: <input type="number" size="7" name="len" value="10" placeholder="アクセス回数" title="アクセス回数"><br>
      <input type="submit" value="テストを開始!"><br>
      </form>
      <hr size="1" color="#7fffd4">
    </div>
    <div align="center"><font style="background-color:#06f5f3;">Copyright &copy; 2022 ActiveTK. All rights reserved.</font></div>
  </body>
</html>
