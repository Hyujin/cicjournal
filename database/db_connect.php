<?php

class DBConnect
{
  private $server;
  private $database;
  private $username1;
  private $password1;
  private $con;

  public function __construct()
  {
    //defaults
    $this->server = "localhost";
    $this->database = "cicjournal";
    //Create another one if this credentials are not applicable
    $this->username1 = "root";
    $this->password1 = "";

    $this->con = new mysqli($this->server,$this->username1,$this->password1,$this->database);

    if(!$this->con){
      die('ERROR CONNECT');
    }else{

    }
  }

  public function getConnection()
  {
    return $this->con;
  }
}




 ?>
