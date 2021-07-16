<?php

class Flowers {

  public static function getFlowers($pdo) {
    if ($_GET['flower_id']) {
      $stmt = $pdo->prepare(
        'SELECT seasons.season, flowers.name, flowers.image, GROUP_CONCAT(meanings.meaning)
        FROM `seasons`
        JOIN categorization ON seasons.id = categorization.season_id
        JOIN flowers ON categorization.flower_id = flowers.id
        JOIN language ON flowers.id = language.flower_id
        JOIN meanings ON language.meaning_id = meanings.id
        GROUP BY flowers.id, seasons.season
        HAVING flowers.id = :flower_num AND seasons.season = :season_name'
      );
      $stmt->bindValue(':flower_num', $_GET['flower_id'], PDO::PARAM_INT);
      $stmt->bindValue(':season_name', $_GET['season'], PDO::PARAM_STR);
      $stmt->execute();
      $flowers = $stmt->fetchAll();
      return $flowers;
    }
  }
}

?>