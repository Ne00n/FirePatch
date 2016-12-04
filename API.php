<?php

include 'Content/config.php';

function loader($class) {
    include 'Class/' . $class . '.php';
}

spl_autoload_register('loader');

$DB = new Database;
$DB->InitDB();

if ($_POST["TOKEN"] == NULL) { die("Token not set" );}
if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["TOKEN"])){ die("Token contains invalid Letters!" );}

if (isset($_POST["JOB_DONE"]) && $_POST["JOB_DONE"] == 1) {

  $Update = 0;

  $stmt = $DB->GetConnection()->prepare("UPDATE Servers SET Update_Running = ? WHERE Token = ?");
  $stmt->bind_param('is', $Update,$_POST["TOKEN"]);
  $rc = $stmt->execute();
  if ( false===$rc ) { die("MySQL Error"); }
  $stmt->close();

  echo 'ok';

} else {

  $stmt = $DB->GetConnection()->prepare("SELECT Update_Running FROM Servers WHERE Token = ? LIMIT 1");
  $stmt->bind_param('s', $_POST["TOKEN"]);
  $rc = $stmt->execute();
  if ( false===$rc ) { die("MySQL Error"); }
  $stmt->bind_result($db_Server_Running);
  $stmt->fetch();
  $stmt->close();

  if (isset($db_Server_Running) && $db_Server_Running == 1) {
    echo 'Update';
  } elseif (isset($db_Server_Running) && $db_Server_Running == 0) {

    $Lastrun = time();

    $stmt = $DB->GetConnection()->prepare("UPDATE Servers SET Lastrun = ? WHERE Token = ?");
    $stmt->bind_param('is', $Lastrun,$_POST["TOKEN"]);
    $rc = $stmt->execute();
    if ( false===$rc ) { die("MySQL Error"); }
    $stmt->close();

    echo 'ok';
  } else {
    die("Invalid Token!");
  }

}

 ?>
