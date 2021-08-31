<?php

require_once(__DIR__ . '/../app/config/config.php');

$title = '花';

$pdo = getPdoInstance($pdo);
$flowers = Flowers::getFlowers($pdo);

$flower_name = Flowers::getName();
$flower_image = Flowers::getImage();
$selected_meaning = Flowers::getMeaning();

// $line_name = filter_input(INPUT_POST, 'line_name');

?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
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
      <form action="new.php" method="get">
        <input type="hidden" name="new_diary" value="new_diary">
        <input type="hidden" name="flower_name" value="<?php echo Utils::h($flower_name); ?>">
        <input type="hidden" name="flower_image" value="<?php echo Utils::h($flower_image); ?>">
        <input type="hidden" name="selected_meaning" value="<?php echo Utils::h($selected_meaning); ?>">
        <input type="submit" class="btn" value="記録をつける ▶︎">
      </form>
    </div>
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
      $(function() {
      liff.getProfile()
        .then(profile => {
          const name = profile.displayName
          $.ajax({
            type: "POST",
            url: "item.php",
            data: {
              line_name: name
            }
          })
        })
      })
    })
  </script>
</body>
</html>