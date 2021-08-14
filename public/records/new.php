<?php
session_start();

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);

Users::getUserIdFromLineIdToken($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/stylesheets/style.css" type="text/css">
  <title>記録をつける</title>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170627472-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-170627472-4');
  </script>
</head>
<body>
  <head>
    <h1>記録をつける</h1>
  </head>
  <main>
    <div>
      <form action="./records.php" method="post">
        <input type="hidden" name="record" value="record">
        <img class="flower-img" src="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>" alt="花の画像">
        <input type="hidden" required name="flower_image" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>">
        <div class="table">
          <div class="table-el">
            <span>日付：</span>
            <span><input type="date" required name="created_at" value="<?php echo date('Y-m-d'); ?>"></span>
          </div>
          <div class="table-el">
            <span>花の名前：</span>
            <span><input type="text" required name="flower_name" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_name'))); ?>"></span>
          </div>
          <div class="table-el">
            <span>選んだ花言葉：</span>
            <span><input type="text" required name="selected_meaning" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'selected_meaning'))); ?>"></span>
          </div>
        </div>
        <textarea name="comment" id="" cols="30" rows="5" placeholder="ひとことコメント"></textarea><br>
        <input type="submit" class="btn" value="この内容で記録をつける ▶︎">
      </form>
      <a href="./records.php">一覧画面へ</a>
    </div>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script>
    liff
    .init({
        liffId: '1656216720-24XArQJK'
    })
    .then(() => {
      if (!liff.isLoggedIn()) {
      liff.login()
      }
      $(function() {
        const idToken = liff.getIDToken();
        console.log(idToken);
        $.ajax({
          type: "POST",
          url: "new.php",
          data: {
            id_token: idToken
          },
          success:function(data) {
            console.log(data);
          },
          error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        })
      })
    })
  </script>
</body>
</html>