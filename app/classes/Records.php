<?php
session_start();

class Records {

  public static function createRecord($pdo) {

    if ($_POST['record']) {

      $created_at = filter_input(INPUT_POST, 'created_at');
      $flower_name = filter_input(INPUT_POST, 'flower_name');
      $selected_meaning = filter_input(INPUT_POST, 'selected_meaning');
      $flower_image = filter_input(INPUT_POST, 'flower_image');
      $comment = filter_input(INPUT_POST, 'comment');
      $user_id = $_SESSION['user_id'];


      $created_at_ymd_array = explode("-", $created_at);
      $created_at_year  = $created_at_ymd_array[0];
      $created_at_month = $created_at_ymd_array[1];
      $created_at_day   = $created_at_ymd_array[2];

      $stmt = $pdo->prepare(
        'INSERT INTO records (created_at_year, created_at_month, created_at_day, flower_name, selected_meaning, flower_image, comment, user_id)
        VALUES(:created_at, :flower_name, :selected_meaning, :flower_image, :comment, :user_id)');
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

  public static function gerRecords($pdo) {
    if ($_SESSION['user_id']) {
      $stmt = $pdo->prepare('SELECT created_at_year, created_at_month, created_at_day, flower_name, selected_meaning, flower_image, comment FROM records WHERE user_id = :user_id ORDER BY id DESC');
      $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
      $stmt->execute();
      $records = $stmt->fetchAll();
      return $records;
    }
  }

}

?>