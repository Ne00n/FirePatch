<?php

class Server {

  private $DB;
  private $error;
  private $id;
  private $token;

  public function __construct($DB) {
    $this->DB = $DB;
  }

  public function addServer($name) {

    if(!preg_match("/^[a-zA-Z0-9._\-]+$/",$name)){ $this->error = "The name of the Server contains invalid letters.";}

    if ($this->error == "") {

      $this->token = bin2hex(random_bytes(20));

      $stmt = $this->DB->GetConnection()->prepare("INSERT INTO Servers(Name,Token) VALUES (?,?)");
      $stmt->bind_param('ss',$name,$this->token);
      $rc = $stmt->execute();
      if ( false===$rc ) { $this->error = "MySQL Error"; }
      $stmt->close();

    }

  }

  public function getAllServers() {

   $data = array();

   $query = "SELECT ID,Name,Lastrun,Lastupdate,Update_Running FROM Servers ORDER by ID ASC";
   $stmt = $this->DB->GetConnection()->prepare($query);
   $stmt->execute();
   $result = $stmt->get_result();
   while ($row = $result->fetch_assoc()) {
     $data[$row['ID']] = array("Name" => $row['Name'],"Lastrun" => $row['Lastrun'],"Lastupdate" => $row['Lastupdate'],"Update_Running" => $row['Update_Running']);
   }

   return $data;

  }

  public function UpdateServer($Update = 1) {

    if ($this->error == "") {

      $stmt = $this->DB->GetConnection()->prepare("UPDATE Servers SET Update_Running = ? WHERE ID = ?");
      $stmt->bind_param('ii', $Update,$this->id);
      $rc = $stmt->execute();
      if ( false===$rc ) { $this->error = "MySQL Error"; }
      $stmt->close();

    }

  }

  public function RemoveServer() {

    if ($this->error == "") {

      $stmt = $this->DB->GetConnection()->prepare("DELETE FROM Servers WHERE ID = ?");
      $stmt->bind_param('i', $this->id);
      $rc = $stmt->execute();
      if ( false===$rc ) { $this->error = "MySQL Error"; }
      $stmt->close();

    }

  }

  public function setID($id) {
    if(preg_match("/^[0-9]+$/",$id)){
      $this->id = $id;
    } else {
      $this->error = 'Invalid ID';
    }
  }

  public function getError() {
    return $this->error;
  }

  public function getToken() {
    return $this->token;
  }

}

 ?>
