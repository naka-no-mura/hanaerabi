<?php

class Utils {
  public static function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  public static function copyText() {
    $startYear = '2021';
    $thisYear = date('Y');

    if ($startYear === $thisYear) {
      return $startYear;
    } else {
      return "{$startYear} - {$thisYear}";
    }
  }

  public static function title($title) {
    $baseTitle = 'ハナエラビ';
    $subTitle = $title;

    if (empty($title)) {
      return $baseTitle;
    } else {
      return "{$subTitle} | {$baseTitle}";
    }
  }
}

?>