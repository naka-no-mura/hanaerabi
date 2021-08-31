<?php
session_start();
require_once(__DIR__ . '/../app/config/config.php');

$title = '記録の編集';

$pdo = getPdoInstance($pdo);

// line_id_tokenからuser_idを取得 => user_idは $session['user_id] に格納
Users::getUserIdFromLineIdToken($pdo);

// 詳細を表示させる
$record = Records::showRecord($pdo);

// 編集処理
Records::UpdateRecord($pdo);


?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <?php print_r($res); ?>
  <head>
    <h1>記録の編集</h1>
  </head>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="edit" value="<?php echo Utils::h($record['id']); ?>">
      <span>現在の画像</span><br>
      <img class="flower-img" src="<?php echo Utils::h($record['flower_image']); ?>" alt="花の画像">
      <input type="hidden" required name="flower_image" value="<?php echo(Utils::h($record['flower_image'])); ?>">
      <div class="table">
        <div class="table-el">
          <span>画像を更新</span><br>
          <input type="file" name="upload_image" style="width: 85%">
        </div>
        <div class="table-el">
          <span>日付</span><br>
          <span><input type="date" required name="created_at" value="<?php echo date('Y-m-d'); ?>"></span>
        </div>
        <div class="table-el">
          <span>花の名前</span><br>
          <span><input type="text" required name="flower_name" value="<?php echo Utils::h($record['flower_name']); ?>"></span>
        </div>
        <div class="table-el">
          <span>選んだ花言葉</span><br>
          <span><input type="text" required name="selected_meaning" value="<?php echo Utils::h($record['selected_meaning']); ?>"></span>
        </div>
        <div class="table-el">
          <span>ひとことコメント</span>
          <textarea name="comment" id="" cols="30" rows="5" placeholder="ご自由にお書きください"><?php echo Utils::h($record['comment']); ?></textarea>
        </div>
      </div>
      <input type="submit" class="btn" value="更新する ▶︎">
    </form>
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
  <script>
    function confirm_delete() {
      var select = confirm("この記録を削除しますか？一度削除したら復元できません。");
      return select;
    }
</script>
</body>
</html>