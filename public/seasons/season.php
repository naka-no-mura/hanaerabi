<?php

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
  <link rel="stylesheet" href="../../app/assets/stylesheets/style.css" type="text/css">
  <title>ハナエラビ</title>
</head>
<body>
  <head>
    <h1>今の季節は？</h1>
  </head>
  <main>
    <?php foreach ($seasons as $season): ?>
      <form action="../meaning/meaning.php" method="get" class="seasons">
        <input type="hidden" name="season" value="<?php echo htmlspecialchars($season, ENT_QUOTES); ?>">
        <input type="submit" class="season" value="<?php echo htmlspecialchars($season, ENT_QUOTES); ?>" >
      </form>
    <?php endforeach; ?>
  </main>
</body>
</html>