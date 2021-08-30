<?php
session_start();
// 詳細。編集、削除が本人かどうかを確認処理を共通化（sessionと受け取ったuser_idが等しいか）
class Records {

  public static function createRecord($pdo) {

    if ($_POST['record']) {

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

      $stmt = $pdo->prepare(
        'INSERT INTO records (created_at_year, created_at_month, created_at_day, flower_name, selected_meaning, flower_image, comment, user_id)
        VALUES(:created_at_year, :created_at_month, :created_at_day, :flower_name, :selected_meaning, :flower_image, :comment, :user_id)');
      $stmt->execute([
        'created_at_year' => $created_at_year,
        'created_at_month' => $created_at_month,
        'created_at_day' => $created_at_day,
        'flower_name' => $flower_name,
        'selected_meaning' => $selected_meaning,
        'flower_image' => $flower_image,
        'comment' => $comment,
        'user_id' => $user_id,
      ]);

      return $res['success'] = '記録を作成しました';
    }
  }

  public static function UpdateRecord($pdo) {
    $edit_id = filter_input(INPUT_POST, 'edit');

    if (!empty($edit_id)) {
      $stmt = $pdo->prepare('SELECT user_id FROM records WHERE id = :id');
      $stmt->bindValue(':id', $edit_id, PDO::PARAM_INT);
      $stmt->execute();
      $res = $stmt->fetch();
      $user_id = $res['user_id'];

      if ($res === false) {
          header('Location: records.php');
          return $res['success'] = '該当の記録は見つかりませんでした';
      }

      // ログイン中のユーザーからのSHOWであれば処理を実行
      if ($user_id === $_SESSION['user_id']) {
        $created_at = filter_input(INPUT_POST, 'created_at');
        $flower_name = filter_input(INPUT_POST, 'flower_name');
        $selected_meaning = filter_input(INPUT_POST, 'selected_meaning');
        $flower_image = filter_input(INPUT_POST, 'flower_image');
        $comment = filter_input(INPUT_POST, 'comment');
        $user_id = $_SESSION['user_id'];

        // 画像がアップロードされた場合
        if (!empty($_FILES['upload_image']['name'])) {

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
            return $res['error'] = '拡張子がjpg、jpeg、png、gifに該当する画像を選択して下さい（拡張子の大文字小文字は区別しません）';
          }
        }

        $created_at_ymd_array = explode("-", $created_at);
        $created_at_year  = $created_at_ymd_array[0];
        $created_at_month = $created_at_ymd_array[1];
        $created_at_day   = $created_at_ymd_array[2];

        $stmt = $pdo->prepare("UPDATE records SET created_at_year = :created_at_year, created_at_month = :created_at_month, created_at_day = :created_at_day, flower_name = :flower_name, selected_meaning = :selected_meaning, flower_image = :flower_image, comment = :comment WHERE id = :id");
        $stmt->execute([
          'created_at_year' => $created_at_year,
          'created_at_month' => $created_at_month,
          'created_at_day' => $created_at_day,
          'flower_name' => $flower_name,
          'selected_meaning' => $selected_meaning,
          'flower_image' => $flower_image,
          'comment' => $comment,
          'id' => $edit_id
        ]);

        header('Location: records.php');

        return $res['success'] = '記録を更新しました';
      } else {
        return $res['error'] = '表示できるのは自分の記録のみです';
      }
    }
  }

  public static function showRecord($pdo) {
    $show_id = filter_input(INPUT_GET, 'show');

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
        return $record;
        return $res['success'] = '記録の詳細です';
      } else {
        return $res['error'] = '表示できるのは自分の記録のみです';
      }
    }
  }

  public static function deleteRecord($pdo) {
    // 削除
    $delete_id = filter_input(INPUT_POST, 'delete');

    if (!empty($delete_id)) {
        $stmt = $pdo->prepare('SELECT user_id FROM records WHERE id = :id');
        $stmt->bindValue(':id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        $user_id = $res['user_id'];

        if ($res === false) {
          header('Location: records.php');
          return $res['success'] = '該当の記録は見つかりませんでした';
        }

      // ログイン中のユーザーからのDELETEであれば処理を実行
      if ($user_id === $_SESSION['user_id']) {
        $stmt = $pdo->prepare('DELETE FROM records WHERE id = :id');
        $stmt->bindValue('id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();
        header ('Location: records.php');
        $res['success'] = '記録を削除しました';
      } else {
        return $res['error'] = '削除できるのは自分の記録のみです';
      }
    }
  }

  public static function getRecords($pdo) {
    if ($_SESSION['user_id']) {
      $stmt = $pdo->prepare('SELECT id, created_at_year, created_at_month, created_at_day, flower_name, selected_meaning, flower_image, comment FROM records WHERE user_id = :user_id ORDER BY id DESC');
      $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
      $stmt->execute();
      $records = $stmt->fetchAll();
      return $records;
    }
  }

  // public static function deleteRecode($pdo) {
  //   $delete = filter_input(INPUT_POST, 'delete');

  //   if (!empty($delete)) {
  //     $stmt = $pdo->prepare('SELECT user_id FROM records WHERE user_id = :user_id');
  //     $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
  //     $stmt->execute();
  //     $user_id = $stmt->fetch();
  //   }
  // }

}

?>