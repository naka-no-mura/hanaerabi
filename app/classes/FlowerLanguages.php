<?php

class FlowerLanguages {

  public static function getFlowerLanguages($pdo) {
    if ($_GET['season']) {
      $stmt = $pdo->prepare(
        'SELECT meanings.meaning, flowers.id, seasons.season
        FROM seasons
        JOIN categorization ON seasons.id = categorization.season_id
        JOIN flowers ON categorization.flower_id = flowers.id
        JOIN language ON flowers.id = language.flower_id
        JOIN meanings ON language.meaning_id = meanings.id
        WHERE seasons.season =:season_name
        GROUP BY meanings.meaning'
      );
      $stmt->bindValue(':season_name', $_GET['season'], PDO::PARAM_STR);
      $stmt->execute();
      $fmeanings = $stmt->fetchAll();
      return $fmeanings;
    }
  }
}

?>