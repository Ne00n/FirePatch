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

#Server tells us, all good, updated done
if (isset($_POST["JOB_DONE"]) && $_POST["JOB_DONE"] == 1) {

  $update = 0;
  $lastupdate = time();

  $stmt = $DB->GetConnection()->prepare("UPDATE Servers SET Update_Running = ?, Lastupdate = ?, Update_Error = ? WHERE Token = ?");
  $stmt->bind_param('iiis', $update,$lastupdate,$update,$_POST["TOKEN"]);
  $rc = $stmt->execute();
  if ( false===$rc ) { die("MySQL Error"); }
  $stmt->close();

  echo 'ok';
#Server tell us, something went wrong, we Display that Error inside the Panel, if it takes Longer the error goes away after some minutes otherwise you need to fix it
} elseif (isset($_POST["JOB_DONE"]) && $_POST["JOB_DONE"] == 4) {

  $error = 1;

  $stmt = $DB->GetConnection()->prepare("UPDATE Servers SET Update_Error = ? WHERE Token = ?");
  $stmt->bind_param('is', $error,$_POST["TOKEN"]);
  $rc = $stmt->execute();
  if ( false===$rc ) { die("MySQL Error"); }
  $stmt->close();

#If the Server is just Posting the Token without anything else, aka Camping for Work
} else {

  #Lets fetch the Update Status from the DB, if we get a result, the Token is correct
  $stmt = $DB->GetConnection()->prepare("SELECT Update_Running FROM Servers WHERE Token = ? LIMIT 1");
  $stmt->bind_param('s', $_POST["TOKEN"]);
  $rc = $stmt->execute();
  if ( false===$rc ) { die("MySQL Error"); }
  $stmt->bind_result($db_Server_Running);
  $stmt->fetch();
  $stmt->close();

  #Token vaild, Updated needed, so we respond
  if (isset($db_Server_Running) && $db_Server_Running == 1) {
    echo 'Update';
  #Token vaild, no Updated needed, but we need to update Lastrun
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
