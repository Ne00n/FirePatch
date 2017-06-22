<?php

include 'content/config.php';

function loader($class) {
    include 'content/class/' . $class . '.php';
}

spl_autoload_register('loader');

$DB = new Database;
$DB->InitDB();

$Lake = new Lake(_db_host,_db_user,_db_password,_db_database);

if (isset($_GET["server"])) {
  $page = $_GET["server"];
} else {
  $page = "";
}

include 'content/main.php';

 ?>
