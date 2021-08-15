<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <head>
    <h1>ハナエラビ</h1>
  </head>
  <main>
    <img src="image/top_flower.jpg" alt="イメージ画像" class="top-img">
    <h3>季節と花言葉を選んで<br>一輪挿し始めてみませんか？</h3>
    <a href="season.php" class="start">はじめる ▶︎</a>
    <p class="logo-tx">ロゴメーカー <a href="https://www.designevo.com/jp/" title="無料オンラインロゴメーカー">DesignEvo</a> にて作成</p>
  </main>
  <?php require_once(__DIR__ . '/./common/footer.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
      const idToken = liff.getIDToken();
      console.log(idToken);
    })
  </script>
</body>
</html>