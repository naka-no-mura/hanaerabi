<?php
session_start();
require_once(__DIR__ . '/../app/config/config.php');

$title = '記録をつける';

$pdo = getPdoInstance($pdo);

Users::getUserIdFromLineIdToken($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <head>
    <h1>記録をつける</h1>
  </head>
  <main>
    <form action="records.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="record" value="record">
      <img class="flower-img" src="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>" alt="花の画像">
      <input type="hidden" required name="flower_image" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>">
      <div class="table">
        <div class="table-el">
          <span>日付</span><br>
          <span><input type="date" required name="created_at" value="<?php echo date('Y-m-d'); ?>"></span>
        </div>
        <div class="table-el">
          <span>花の名前</span><br>
          <span><input type="text" required name="flower_name" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_name'))); ?>"></span>
        </div>
        <div class="table-el">
          <span>選んだ花言葉</span><br>
          <span><input type="text" required name="selected_meaning" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'selected_meaning'))); ?>"></span>
        </div>
        <div class="table-el">
          <span>写真を投稿</span><br>
          <input type="file" name="upload_image" style="width: 85%">
        </div>
        <div class="table-el">
          <span>ひとことコメント</span>
          <textarea name="comment" id="" cols="30" rows="5" placeholder="ご自由にお書きください"></textarea>
        </div>
      </div>
      <input type="submit" class="btn" value="この内容で記録をつける ▶︎">
    </form>
    <a href="records.php">一覧画面へ</a>
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