<?php

require_once 'database.class.php';

if(!class_exists('Mysqli')) {

  class Mysqli extends Database {
    
    public function __construct() { }

    /**
     * A function to get a user id's related name
     * @param $user_id int - the user's id
     * @return $name string - the user's name
     */
    public function getUserName($user_id) {
      $mysqli = $this->connect();

      $query = "SELECT name FROM users WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($name);
	$stmt->fetch();
	
	return $name;
      }

      $stmt->close();
      $mysqli->close();
    }

  }
}

?>