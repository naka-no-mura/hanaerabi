<?php
session_start();
require_once(__DIR__ . '/../app/config/config.php');

$title = '記録の編集';

$pdo = getPdoInstance($pdo);

// line_id_tokenからuser_idを取得 => user_idは $session['user_id] に格納
Users::getUserIdFromLineIdToken($pdo);

$show_id = filter_input(INPUT_GET, 'show');

// 詳細を表示させる
if (!empty($show_id)) {
    $stmt = $pdo->prepare('SELECT user_id FROM records WHERE id = :id');
    $stmt->bindValue(':id', $show_id, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();
    $user_id = $res['user_id'];

    if ($res === false) {
      header('Location: records.php');
      return $res['success'] = '該当の記録は見つかりませんでした';
    }

  // ログイン中のユーザーからのSHOWであれば処理を実行
  if ($user_id === $_SESSION['user_id']) {
    $stmt = $pdo->prepare('SELECT id, created_at_year, created_at_month, created_at_day, flower_name, selected_meaning, flower_image, comment FROM records WHERE id = :id');
    $stmt->bindValue('id', $show_id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch();
    // return $res['success'] = '記録の詳細です';
  } else {
    return $res['error'] = '表示できるのは自分の記録のみです';
  }
}

// 編集処理
$edit = filter_input(INPUT_POST, 'edit');

    if (!empty($edit)) {

      $created_at = filter_input(INPUT_POST, 'created_at');
      $flower_name = filter_input(INPUT_POST, 'flower_name');
      $selected_meaning = filter_input(INPUT_POST, 'selected_meaning');
      $flower_image = filter_input(INPUT_POST, 'flower_image');
      $comment = filter_input(INPUT_POST, 'comment');
      $user_id = $_SESSION['user_id'];

      // 画像がアップロードされた場合
      if (!empty($_FILES)) {

        // 拡張子をチェックしてjpg,jpeg,png,gifのみアップロード許可
        $file_exts = strtolower(pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION));
        $allow_exts = ['jpg', 'jpeg', 'png', 'gif'];
        $exts_res = in_array($file_exts, $allow_exts);

        if ($exts_res === true) {

          // 500kbを超えていたらリサイズ
          if ($_FILES['upload_image']['size'] > 500000) {
            $upload_tmp_pass = $_FILES['upload_image']['tmp_name'];
            list($src_w, $src_h, $type) = getimagesize($upload_tmp_pass);
            $new_w = $src_w * 0.2;
            $new_h = $src_h * 0.2;

            switch ($type) {
              case 1: //GIF
                $baseimage = imagecreatefromgif($upload_tmp_pass);
                break;
              case 2: //JPEG
                $baseimage = imagecreatefromjpeg($upload_tmp_pass);
                break;
              case 3: //PNG
                $baseimage = imagecreatefrompng($upload_tmp_pass);
                break;
              default:
                return false;
            }

            $new_image = imagecreatetruecolor($new_w, $new_h);
            imagecopyresampled($new_image, $baseimage, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);

            switch ($type) {
              case 1: //GIF
                imagegif($new_image, $upload_tmp_pass, 50);
                break;
              case 2: //JPEG
                imagejpeg($new_image, $upload_tmp_pass, 50);
                break;
              case 3: //PNG
                imagepng($new_image, $upload_tmp_pass, 50);
                break;
              default:
                return false;
            }
          }

          $image_name = uniqid(mt_rand(), true) . '.' . $file_exts;
          $image_pass = __DIR__ . "/../../public/image/$image_name";
          $image_pass_for_db = "image/$image_name";
          $upload_res = move_uploaded_file($_FILES['upload_image']['tmp_name'], $image_pass);

          // 画像をサーバーに保存できたらデフォルトの画像からアップロードされた画像に更新
          if ($upload_res === true) {
            $flower_image = $image_pass_for_db;
          }
        } else {
          // return $res['error'] = '拡張子がjpg、jpeg、png、gifに該当する画像を選択して下さい（拡張子の大文字小文字は区別しません）';
        }
      }

      $created_at_ymd_array = explode("-", $created_at);
      $created_at_year  = $created_at_ymd_array[0];
      $created_at_month = $created_at_ymd_array[1];
      $created_at_day   = $created_at_ymd_array[2];

      $sql = "UPDATE records SET created_at_year = $created_at_year, created_at_month = $created_at_month, created_at_day = $created_at_day, flower_name = $flower_name, selected_meaning = $selected_meaning, flower_image = $flower_image, comment = $comment";

      $stmt = $pdo->query($spl);
      $res = $stmt->fetch();
      header('Location: records.php');

      // return $res['success'] = '記録を作成しました';
    }


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
      <input type="hidden" name="edit" value="edit">
      <input type="hidden" name="show" value="<?php echo Utils::h($record['id']); ?>">
      <span>現在の画像</span><br>
      <img class="flower-img" src="<?php echo Utils::h($record['flower_image']); ?>" alt="花の画像">
      <input type="hidden" required name="flower_image" value="<?php echo(Utils::h((string)filter_input(INPUT_GET, 'flower_image'))); ?>">
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