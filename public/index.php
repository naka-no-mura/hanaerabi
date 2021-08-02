<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/stylesheets/style.css" type="text/css">
  <script src="assets/javascript/main.js" type="text/javascript"></script>
  <title>ハナエラビ</title>
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
    <h1>ハナエラビ</h1>
  </head>
  <main>
    <img src="image/top_flower.jpg" alt="イメージ画像" class="top-img">
    <h3>季節と花言葉を選んで<br>一輪挿し始めてみませんか？</h3>
    <a href="seasons/season.php" class="start">はじめる ▶︎</a>
    <p class="logo-tx">ロゴメーカー <a href="https://www.designevo.com/jp/" title="無料オンラインロゴメーカー">DesignEvo</a> にて作成</p>
  </main>
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