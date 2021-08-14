<?php
session_start();

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);

$res = Records::createRecord($pdo);
echo $res;

// line_id_tokenからuser_idを取得 => user_idは $session['user_id] に格納
Users::getUserIdFromLineIdToken($pdo);

// user_idに紐づいた記録を全て取得
$records = Records::gerRecords($pdo);


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
  <title>わたしの記録</title>
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
    <h1>わたしの記録</h1>
  </head>
  <main>
    <?php foreach ($records as $record): ?>
      <div class="card">
        <div class="created-day">
          <span><small class="created-yaer"><?php echo Utils::h($record['created_at_year']); ?></small><br><b><?php echo Utils::h($record['created_at_month']); ?> / <?php echo Utils::h($record['created_at_day']); ?></b></span>
        </div>
          <img class="flower-img" src="<?php echo Utils::h($record['flower_image']) ?>" alt="花の写真">
        <h3 class="flower-name"><?php echo Utils::h($record['flower_name']); ?> ： <?php echo Utils::h($record['selected_meaning']); ?></h3>
        <div class="content">
          <p><?php echo Utils::h($record['comment']); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
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
        $.ajax({
          type: "POST",
          url: "records.php",
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