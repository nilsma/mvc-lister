<?php

if(!class_exists('Database')) {

  class Database {
    
    private $host = 'localhost';
    private $username = 'root';
    private $password = '8kMkyg()';
    private $database = 'mvc_lister';

    public function __construct() { }

    public function connect() {
      $mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);

      if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }

      if (!$mysqli->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $mysqli->error);
      } 

      return $mysqli;
    }
  }
}
?>