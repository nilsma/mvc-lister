<?php

require_once 'database.class.php';

if(!class_exists('Model')) {

  class Model extends Database {

    public function __construct() { }

    public function getItems() {
      $mysqli = $this->connect();

      $query = "SELECT id, name FROM items";

      $stmt = $mysqli->stmt_init();
      
      if(!$stmt->prepare($query)) {
	echo 'ballerusk!';
      } else {
	$results = array();
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while($stmt->fetch()) {
	  $results[] = array(
			     'id' => $id,
			     'name' => $name
			     );
	}

	return $results;
      }
    }

  }

}

?>