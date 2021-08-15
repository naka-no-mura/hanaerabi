<?php

require_once(__DIR__ . '/../app/config/config.php');

$seasons = ['春', '夏', '秋', '冬'];

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
  <link rel="stylesheet" href="assets/stylesheets/style.css" type="text/css">
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
    <h1>今の季節は？</h1>
  </head>
  <main>
    <div class="season-page">
      <?php foreach ($seasons as $season): ?>
        <form action="meaning.php" method="get" class="seasons">
          <input type="hidden" name="season" value="<?php echo Utils::h($season); ?>">
          <input type="submit" class="season" value="<?php echo Utils::h($season); ?>" >
        </form>
      <?php endforeach; ?>
    </div>
  </main>
  <?php require_once(__DIR__ . '/./common/footer.php'); ?>
</body>
</html>