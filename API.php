<?php

include 'content/config.php';

function loader($class) {
    include 'content/class/' . $class . '.php';
}

spl_autoload_register('loader');

$Lake = new Lake(_db_host,_db_user,_db_password,_db_database);

if ($_POST["TOKEN"] == NULL) { die("Token not set" );}
if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["TOKEN"])){ die("Token contains invalid Letters!" );}

#Server tells us, all good, update done
if (isset($_POST["JOB_DONE"]) && $_POST["JOB_DONE"] == 1) {

  $Lake->UPDATE('Servers')->SET(array('Update_Running' => 0,'Lastupdate' => time(),'Update_Error' => 0))->WHERE(array('Token' => $_POST["TOKEN"]))->VAR('iiis')->DONE();
  if ($Lake->getSuccess() === false) { die("MySQL Error"); }
  echo 'ok';

#Server tell us, something went wrong, we Display that Error inside the Panel, if it takes Longer the error goes away after some minutes otherwise you need to fix it
} elseif (isset($_POST["JOB_DONE"]) && $_POST["JOB_DONE"] == 4) {

  $Lake->UPDATE('Servers')->SET(array('Update_Error' => 1))->WHERE(array('Token' => $_POST["TOKEN"]))->VAR('is')->DONE();
  if ($Lake->getSuccess() === false) { die("MySQL Error"); }

#If the Server is just Posting the Token without anything else, aka Camping for Work
} else {

  #Lets fetch the Update Status from the DB, if we get a result, the Token is correct
  $results = $Lake->SELECT(array('Update_Running'))->FROM('Servers')->WHERE(array('Token' => $_POST["TOKEN"]))->VAR('s')->DONE();
  if ($Lake->getSuccess() === false) { die("MySQL Error"); }

  #Token vaild, Updated needed, so we respond
  if (isset($results['0']['Update_Running']) && $results['0']['Update_Running'] == 1) {
    echo 'Update';
  #Token vaild, no Updated needed, but we need to update Lastrun
  } elseif (isset($results['0']['Update_Running']) && $results['0']['Update_Running'] == 0) {

    $Lake->UPDATE('Servers')->SET(array('Lastrun' => time()))->WHERE(array('Token' => $_POST["TOKEN"]))->VAR('is')->DONE();
    if ($Lake->getSuccess() === false) { die("MySQL Error"); }
    echo 'ok';

  } else {
    die("Invalid Token!");
  }

}

?>
