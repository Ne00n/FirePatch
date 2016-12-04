<?php

include 'Content/config.php';

function loader($class) {
    include 'Class/' . $class . '.php';
}

spl_autoload_register('loader');

$DB = new Database;
$DB->InitDB();

if (isset($_GET["server"])) {
  $page = $_GET["server"];
} else {
  $page = "";
}

include 'Content/main.php';

 ?>
