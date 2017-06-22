<?php

class Database {

  private $Database;

  public function InitDB() {
      $this->Database = new mysqli(_db_host, _db_user, _db_password, _db_database);
      if ($this->Database->connect_error) {
         echo "Not connected, error: " .   $this->Database->connect_error;
         exit;
      }
  }

  public function GetConnection() {
      return $this->Database;
  }

}

 ?>
