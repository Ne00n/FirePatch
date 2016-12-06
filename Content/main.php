<?php
include 'header.php';
include 'navbar.php';
?>

<div class="container starter-template">

<?php

if ($page == 'add') {

  if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['confirm'])) {

    $Server = new Server($DB);
    $Server->addServer($_POST['name']);
    if ($Server->getError() == "") {
      echo '<div class="alert alert-success" role="alert"><center>Success, you need to run this Command on your Debian Server to Deploy the Agent:<pre>wget '._script_path.'install.sh && bash install.sh '. $Server->getToken().'</pre></center></div>';
    } else {
      echo '<div class="alert alert-danger" role="alert"><center>'.$Server->getError().'</center></div>';
    }

  } else { ?>

  <form class="form-horizontal" action="index.php?server=add" method="post">
      <div class="form-group">
        <label class="control-label col-sm-2">Name:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control input-sm" name="name" placeholder="Chewbacca">
        </div>
      </div>
      <div class="form-group">
          <button type="submit" name="confirm" class="btn btn-primary">Installation</button>
      </div>
</form>

<?php }
 }

 if (Page::startsWith($page,'update')) {

   $id = str_replace("update?", "", $page);

   $Server = new Server($DB);
   $Server->setID($id);
   $Server->UpdateServer();
   if ($Server->getError() == "") {
     echo '<div class="alert alert-success" role="alert"><center>Success</center></div>';
   } else {
     echo '<div class="alert alert-danger" role="alert"><center>'.$Server->getError().'</center></div>';
   }

 }

 if (Page::startsWith($page,'remove')) {

   $id = str_replace("remove?", "", $page);

   if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['confirm'])) {

     $Server = new Server($DB);
     $Server->setID($id);
     $Server->RemoveServer();
     if ($Server->getError() == "") {
       echo '<div class="alert alert-success" role="alert"><center>Success</center></div>';
     } else {
       echo '<div class="alert alert-danger" role="alert"><center>'.$Server->getError().'</center></div>';
     }

   } else {

   ?>

   <p>Are you sure, that you want to delete this Server?</p>

   <form class="form-horizontal" action="index.php?server=remove?<?= Page::escape($id) ?>" method="post">
     <div class="form-group">
         <button type="submit" name="confirm" class="btn btn-danger">Yes</button><a href="index.php"><button class="btn btn-primary" type="button">No</button></a>
     </div>
   </form>

   <?php }

 }


 ?>

  <div class="table-responsive table-hover">
      <table class="table">
        <thead>
          <tr>
            <th>Server</th>
            <th>Lastrun</th>
            <th>Lastupdate</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php

          $Server = new Server($DB);
          $data = $Server->getAllServers();

          foreach ($data as $key => $element) {

            echo '<tr class="'.($element['Update_Error'] ? " warning" : "").'">';
            echo '<td class="text-left">'.Page::escape($element['Name']).'</td>';
            echo '<td class="text-left">'.($element['Lastrun'] == 0 ? "Never" : Page::escape(date("d.m.Y H:i:s",$element['Lastrun']))).'</td>';
            echo '<td class="text-left">'.($element['Lastupdate'] == 0 ? "Never" : Page::escape(date("d.m.Y H:i:s",$element['Lastupdate']))).'</td>';
            echo '<td class="text-left">'.($element['Update_Running'] ? '<a href=""><button class="btn btn-warning btn-xs" type="button" disabled><i class="fa fa-spinner fa-spin"></i></button></a>' : '<a href="index.php?server=update?'.Page::escape($key).'"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-cloud-upload"></i></button></a>');
            echo '<a href="index.php?server=remove?'.Page::escape($key).'"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-remove"></i></button></a></td>';
            echo '</tr>';

          } ?>

        </tbody>
     </table>
  </div>
  <div class="form-group">
          <a href="index.php?server=add"><button class="btn btn-primary" type="button">Add a Server</button></a>
  </div>

</div>

<?php include 'footer.php'; ?>
