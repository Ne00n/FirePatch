<?php

class Page {

  public static function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
  }

  public static function escape($text) {
    return htmlspecialchars($text,ENT_QUOTES);
  }

}

 ?>
