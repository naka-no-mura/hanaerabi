<?php

require_once(__DIR__ . '/../../app/config/config.php');

// これいらないかも？
$pdo = getPdoInstance($pdo);

$line_id_token = filter_input(INPUT_POST, 'id_token');
echo '確認用' . $line_id_token;

if (!empty($line_id_token)) {
  $stmt = $pdo->prepare( 'INSERT INTO users (line_id_token) VALUES(:line_id_token)');
  $stmt->execute(['line_id_token' => $line_id_token]);
} else {
  echo 'LINE IDトークンがありません';
}

if ($_GET['user_id']) {
  $stmt = $pdo->prepare(
    'INSERT INTO records (created_at, flower_name, selected_meaning, flower_image, comment, user_id)
    VALUES(:created_at, :flower_name, :selected_meaning, :flower_image, :comment, :user_id)');
  $stmt->execute([
    'created_at' => filter_input(INPUT_GET, 'created_at'),
    'flower_name' => filter_input(INPUT_GET, 'flower_name'),
    'selected_meaning' => filter_input(INPUT_GET, 'selected_meaning'),
    'flower_image' => filter_input(INPUT_GET, 'flower_image'),
    'comment' => filter_input(INPUT_GET, 'comment'),
    'user_id' => filter_input(INPUT_GET, 'user_id'),
  ]);
}

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
  <title>記録をつける</title>
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
    <h1>記録をつける</h1>
  </head>
  <main>
    <div>
      <form action="" method="get">
        <input type="hidden" name="user_id" value="1">
        <img src="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>" alt="花の画像">
        <input type="hidden" name="flower_image" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>">
        <table>
          <tr>
            <td>日付</td>
            <td><input type="date" name="created_at" value="<?php echo date('Y-m-d'); ?>"></td>
          </tr>
          <tr>
            <td>花の名前</td>
            <td><?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_name'))); ?></td>
            <input type="hidden" name="flower_name" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_name'))); ?>">
          </tr>
          <tr>
            <td>選んだ花言葉</td>
            <td><?php echo(Utils::h((string)filter_input(INPUT_GET, 'selected_meaning'))); ?></td>
            <input type="hidden" name="selected_meaning" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'selected_meaning'))); ?>">
          </tr>
        </table>
        <textarea name="comment" id="" cols="30" rows="5" placeholder="ひとことコメント"></textarea><br>
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
      const idToken = liff.getIDToken();
      console.log(idToken);
      $(function() {
        $.ajax({
          type: "POST",
          url: "new.php",
          data: {
            id_token: idToken
          }
        })
      })
    })
    .catch((err) => {
      console.log('ajax失敗', err);
    });
  </script>
</body>
</html>