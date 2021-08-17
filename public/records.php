<?php
session_start();
require_once(__DIR__ . '/../app/config/config.php');

$title = '記録一覧';

$pdo = getPdoInstance($pdo);

$res = Records::createRecord($pdo);

// line_id_tokenからuser_idを取得 => user_idは $session['user_id] に格納
Users::getUserIdFromLineIdToken($pdo);

// user_idに紐づいた記録を全て取得
$records = Records::gerRecords($pdo);





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
        return $res['success'] = '記録を削除しました';
      } else {
        return $res['error'] = '削除できるのは自分の記録のみです';
      }
    }



?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <?php print_r($res); ?>
  <head>
    <h1>わたしの記録</h1>
  </head>
  <main>
    <?php foreach ($records as $record): ?>
      <div class="card">
        <div class="created-day">
          <span><small class="created-yaer"><?php echo Utils::h($record['created_at_year']); ?></small><br><b><?php echo Utils::h($record['created_at_month']); ?> / <?php echo Utils::h($record['created_at_day']); ?></b></span>
        </div>
        <div class="modal-btn">
          <a class="js-modal-open" href="">•••</a>
        </div>
        <!-- モーダル -->
        <div class="modal js-modal">
          <div class="modal-bg js-modal-close"></div>
          <div class="modal-content">
            <a class="js-modal-close" href="">×</a>
            <div class="edit-delete">
              <form action="./edit.php" method="get">
                <input type="hidden" name="show" value="<?php echo Utils::h($record['id']); ?>">
                <input class="edit" type="submit" value="編集 ▶︎">
              </form>
              <form action="" method="post" onsubmit="return confirm_delete()">
                <input type="hidden" name="delete" value="<?php echo Utils::h($record['id']); ?>">
                <input class="delete" type="submit" value="削除 ▶︎">
              </form>
            </div>
          </div>
        </div>
        <!-- モーダル -->
        <div>
          <img class="flower-img" src="<?php echo Utils::h($record['flower_image']) ?>" alt="花の写真">
        </div>
        <h3 class="flower-name"><?php echo Utils::h($record['flower_name']); ?> ： <?php echo Utils::h($record['selected_meaning']); ?></h3>
        <div class="content">
          <p><?php echo Utils::h($record['comment']); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
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
$(function(){
    $('.js-modal-open').on('click',function(){
        $('.js-modal').fadeIn();
        return false;
    });
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
});
</script>
</body>
</html>