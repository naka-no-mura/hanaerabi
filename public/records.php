<?php
session_start();
require_once(__DIR__ . '/../app/config/config.php');

$title = '記録一覧';

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
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
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
  <?php require_once(__DIR__ . '/./common/footer.php'); ?>
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