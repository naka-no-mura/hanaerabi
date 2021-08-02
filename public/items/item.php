<?php

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);
$flowers = Flowers::getFlowers($pdo);

$flower_name = Flowers::getName();
$flower_image = Flowers::getImage();
$selected_meaning = Flowers::getMeaning();

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
    <h1>そんなあなたへは</h1>
  </head>
  <main>
    <div>
      <?php foreach($flowers as $flower): ?>
        <h2 class="flower-name"><?php echo Utils::h($flower['name']); ?></h2>
        <p>花言葉は・・・</p>
        <p><big><?php echo Utils::h($flower['GROUP_CONCAT(meanings.meaning)']); ?></big></p>
        <img class="flower-img" src="<?php echo Utils::h($flower['image']); ?>" alt="花の画像">
      <?php endforeach; ?>
      <form action="../diaries/new.php" method="get">
        <input type="hidden" name="new_diary" value="new_diary">
        <input type="hidden" name="flower_name" value="<?php echo Utils::h($flower_name); ?>">
        <input type="hidden" name="flower_image" value="<?php echo Utils::h($flower_image); ?>">
        <input type="hidden" name="selected_meaning" value="<?php echo Utils::h($selected_meaning); ?>">
        <input type="submit" value="記録をつける">
      </form>
    </div>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script>
    liff
    .init({
        liffId: '1656216720-24XArQJK'
    })
    .then(() => {
      liff.getProfile()
      .then(profile => {
        const name = profile.displayName
        console.log(name);
      })
      .catch((err) => {
        console.log('error', err);
      });
    })
  </script>
</body>
</html>